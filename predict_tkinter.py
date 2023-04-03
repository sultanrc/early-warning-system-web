from tkinter import *
from keras.models import load_model
import numpy as np
import datetime as dt
import requests as req
import xml.etree.ElementTree as ET

class Predict:
    def __init__(self):
        self.mean_dataSuhuOut = 25.2320987654321
        self.mean_dataSuhuInd = 22.713827160493828
        self.mean_dataSuhu_ac = 20.776954732510287
        self.std_dataSuhuOut  = 2.3037897116518424
        self.std_dataSuhuInd  = 1.5215510019739682
        self.std_dataSuhu_ac  = 1.3482360774673696
        self.model = load_model('mymodel.h5')

    def predict(self, suhu_luar_besok=0, suhu_ac_besok=0, str=""):
        if str == "bmkg":
            return 0;
        suhu_luar_besok = float(suhu_luar_besok)
        suhu_ac_besok = float(suhu_ac_besok)
        suhu_luar_besok_norm = (suhu_luar_besok - self.mean_dataSuhuOut) / self.std_dataSuhuOut
        suhu_ac_besok_norm = (suhu_ac_besok - self.mean_dataSuhu_ac) / self.std_dataSuhu_ac
        input_data = np.array([[suhu_luar_besok_norm, suhu_ac_besok_norm]])
        pred = self.model.predict(input_data)
        pred = pred * self.std_dataSuhuInd + self.mean_dataSuhuInd
        return pred[0][0]

class Cuaca:   
    def get_data(self, str):
        if str == "bmkg":
            url = "http://data.bmkg.go.id/datamkg/MEWS/DigitalForecast/DigitalForecast-JawaTengah.xml"
            response = req.get(url)
            tree = ET.fromstring(response.content)
            return tree
        else:
            return "Data is Null"

LFONT = ("Dejavu Sans", 12, "bold") #Large Font
SFONT = ("Times New Roman", 10) #Small Font
CY = ("Cyan3")
DO = ("Dark Orange")
SN = ("Snow")
BL = ("Black")

class GUIBuild(Tk):
    def __init__(self, *args, **kwargs):

        Tk.__init__(self, *args, **kwargs)
        container = Frame(self)
        container.pack(side="top", fill="both", expand=True)
        container.grid_rowconfigure(0, weight=1)
        container.grid_columnconfigure(0, weight=1)

        self.frames = {}
        frame = Home(container, self)
        self.frames[Home] = frame
        frame.grid(row=0, column=0, sticky="nsew")

        # for F in (Home):
        #     frame = F(container, self)
        #     self.frames[F] = frame
        #     frame.grid(row=0, column=0, sticky="nsew")

        self.show_frame(Home)

    def show_frame(self, cont):
        frame = self.frames[cont]
        frame.tkraise()

class Home(Frame):
    def __init__(self, parent, controller):
        Frame.__init__(self, parent)
        Frame.configure(self, background=CY)
        titleLabel = Label(self, text="Welcome to Predict App", font=LFONT, bg=CY)
        menuLabel = Label(self, text="Which One: ", font=LFONT, bg=CY)
        titleLabel.pack(pady=0,padx=25)
        menuLabel.pack()

        acLabel = Label(self, text="Set AC Temp Tomorow: ", font=SFONT, bg=SN)
        acLabel.pack()

        acField = Entry(self, width=5)
        acField.pack(pady=3, padx=5, ipadx=10)
        acField.focus_set()

        outLabel = Label(self, text="Set Outside Temp Tomorow: ", font=SFONT, bg=SN)
        outLabel.pack()

        outField = Entry(self, width=5)
        outField.pack(pady=3, padx=5, ipadx=10)

        checkbutton = Button(self, text="Check", font=SFONT, bg=DO, fg=SN, width=15, 
                                        command=lambda:check_pred(outField.get(), acField.get()))  
        bmkgButton = Button(self, text="Check Based BMKG", font=SFONT, bg=DO, fg=SN, width=15,
                                        command=lambda:check_pred("", "", "bmkg"))
        checkbutton.pack(pady=2)
        bmkgButton.pack(pady=2)

        empty = Label(self, text="Input is Null!!!", font=LFONT, bg=CY)

        def clear():
            acField.delete(0, END)
            outField.delete(0, END)

        def check_pred(out, ac, str=""):
            if str == "bmkg":
                resultValue = Label(self, text=f"Predicted Temp: {Predict().predict('', '', str):.2f}°C", font=SFONT, bg=SN)
                resultValue.pack()
            else:
                if ac == "" or out == "":
                    empty.pack()
                    clear()
                    empty.after(3000, disappear)
                else:
                    resultValue = Label(self, text=f"Predicted Temp: {Predict().predict(out, ac):.2f}°C", font=SFONT, bg=SN)
                    resultValue.pack()

        def disappear():
            empty.forget()

if __name__ == "__main__":
    app = GUIBuild()
    app.title("Prediksi")
    app.mainloop()