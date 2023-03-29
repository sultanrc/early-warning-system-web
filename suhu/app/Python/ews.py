# Import library untuk menghubungkan Google Drive dengan Google Colab
# from google.colab import drive

# Mount Google Drive pada Google Colab
# drive.mount('/content/drive')

# Set path ke folder yang berisi file JSON
import os

# Mengubah path direktori menjadi path direktori yang sesuai di lingkungan lokal
os.chdir('F:/XAMPP/htdocs/suhu/app/Python/')

from google.oauth2 import service_account
from googleapiclient.discovery import build

# set kredensial untuk API access
SCOPES = ['https://www.googleapis.com/auth/spreadsheets']
SERVICE_ACCOUNT_FILE = 'key_GoogleSheetAPI.json'

# Mengubah path file json ke path lokal
creds = None
creds = service_account.Credentials.from_service_account_file(
    'F:/XAMPP/htdocs/suhu/app/Python/' + SERVICE_ACCOUNT_FILE, scopes=SCOPES)

SPREADSHEET_ID = '1UeT7sqIsS8Ni3yLz6fh5GOBNJveyCpF_XAtQMRWC1Mo'
RANGE_NAME = 'Sheet1!J2:L1216'

# buat koneksi ke Google Sheets API
service = build('sheets', 'v4', credentials=creds)
result = service.spreadsheets().values().get(
    spreadsheetId=SPREADSHEET_ID, range=RANGE_NAME).execute()
values = result.get('values', [])

dataSuhuInd, dataSuhuOut, dataSuhu_ac = [], [], []

for sublist in values:
  x1, x2, x3 = sublist
  dataSuhuInd.append(float(x1))
  dataSuhuOut.append(float(x2))
  dataSuhu_ac.append(float(x3))

import numpy as np

num_samples = 1215
indTemp = np.array(dataSuhuInd)
outTemp = np.array(dataSuhuOut)
ac_temp = np.array(dataSuhu_ac)

# Normalize the data Z-Score
indTemp_norm = (indTemp - np.mean(indTemp)) / np.std(indTemp)
outTemp_norm = (outTemp - np.mean(outTemp)) / np.std(outTemp)
ac_temp_norm = (ac_temp - np.mean(ac_temp)) / np.std(ac_temp)

# Create the input data and output labels
X = np.column_stack((outTemp_norm, ac_temp_norm))
y = indTemp_norm.reshape(-1, 1)

# Split the data into training and testing sets
train_ratio = 0.8
train_size = int(train_ratio * num_samples)
X_train, y_train = X[:train_size], y[:train_size]
X_test, y_test = X[train_size:], y[train_size:]

import tensorflow as tf
# Define the model
model = tf.keras.models.Sequential([
    tf.keras.layers.Dense(64, activation='relu', input_shape=(2,)),
    tf.keras.layers.Dense(64, activation='relu'),
    tf.keras.layers.Dense(1)
])

# Compile the model
model.compile(loss='mse', optimizer='adam', metrics=['mae'])

# Train the model
history = model.fit(X_train, y_train, epochs=100, batch_size=32,
                    validation_data=(X_test, y_test))

# Evaluate model
loss, accuracy = model.evaluate(X_test, y_test)

# Mengambil data suhu luar ruangan dan suhu AC besok
import cgi
form = cgi.FieldStorage()
suhu_luar_besok = float(form.getvalue('suhu_luar_besok'))
suhu_ac_besok = float(form.getvalue('suhu_ac_besok'))

# Normalisasi z-score pada data suhu luar ruangan dan suhu AC besok
suhu_luar_besok_norm = (suhu_luar_besok - np.mean(dataSuhuOut)) / np.std(dataSuhuOut)
suhu_ac_besok_norm = (suhu_ac_besok - np.mean(dataSuhu_ac)) / np.std(dataSuhu_ac)

# Membuat input data untuk prediksi
input_data = np.array([[suhu_luar_besok_norm, suhu_ac_besok_norm]])

# Melakukan prediksi suhu dalam ruangan besok
prediksi_suhu_besok = model.predict(input_data)

# Mengembalikan prediksi suhu dalam skala asli
prediksi_suhu_besok = prediksi_suhu_besok * np.std(dataSuhuInd) + np.mean(dataSuhuInd)

print('Prediksi suhu dalam ruangan besok:', prediksi_suhu_besok[0][0])