from keras.models import load_model
import numpy as np
import sys

mean_dataSuhuOut = 25.2320987654321
mean_dataSuhuInd = 22.713827160493828
mean_dataSuhu_ac = 20.776954732510287
std_dataSuhuOut  = 2.3037897116518424
std_dataSuhuInd  = 1.5215510019739682
std_dataSuhu_ac  = 1.3482360774673696

model = load_model('F:/XAMPP/htdocs/suhu/app/Python/mymodel.h5')

suhu_luar_besok = float(sys.argv[1])
suhu_ac_besok = float(sys.argv[2])

suhu_luar_besok_norm = (suhu_luar_besok - mean_dataSuhuOut) / std_dataSuhuOut
suhu_ac_besok_norm = (suhu_ac_besok - mean_dataSuhu_ac) / std_dataSuhu_ac

input_data = np.array([[suhu_luar_besok_norm, suhu_ac_besok_norm]])

pred = model.predict(input_data)

pred = pred * std_dataSuhuInd + mean_dataSuhuInd

print(f'{pred[0][0]:.2f}')
