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
    
    def predict(self, outBesok, ac_besok, str):
        if str == "bmkg":
            if Cuaca().get_data() == 0:
                return 0
            ac_besok = float(Cuaca().get_data())
            outBesok = float(20)

        suhu_luar_besok_norm = (outBesok - self.mean_dataSuhuOut) / self.std_dataSuhuOut
        suhu_ac_besok_norm = (ac_besok - self.mean_dataSuhu_ac) / self.std_dataSuhu_ac
        input_data = np.array([[suhu_luar_besok_norm, suhu_ac_besok_norm]])
        pred = self.model.predict(input_data)
        pred = pred * self.std_dataSuhuInd + self.mean_dataSuhuInd
        return pred[0][0]
        
class Cuaca:   
    def get_data(self):
        try:
            now = dt.datetime.now()
            if now.hour < 6:
                now = now.strftime("%Y%m%d0600")
            elif now.hour < 12:
                now = now.strftime("%Y%m%d1200")
            elif now.hour < 18:
                now = now.strftime("%Y%m%d1800")
            url = 'https://data.bmkg.go.id/DataMKG/MEWS/DigitalForecast/DigitalForecast-Jambi.xml'
            response = req.get(url)
            xml_text = response.content

            # Parse the XML data into an ElementTree object
            root = ET.fromstring(xml_text)

            # Find the area with the ID 501208 and get the temperature value for the current time period (now)
            suhu = None
            for area_elem in root.iter('area'):
                if area_elem.get('id') == '501208':
                    for parameter in area_elem.findall('.//parameter'):
                        if parameter.attrib['description'] == 'Temperature':
                            for timerange in parameter:
                                if timerange.attrib['datetime'] == now:
                                    for value in timerange:
                                        suhu = value.text
                                        break
            
            return suhu
        except:
            return 0  

LFONT = ("Roboto Regular", 12, "bold") #Large Font
SFONT = ("Roboto Regular", 10) #Small Font
CY = ("Dark Orange")
DO = ("Red")
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
        titleLabel = Label(self, text="PREDICT APP", font=LFONT, bg=CY, fg=SN)
        titleLabel.pack(pady=0,padx=25)

        outLabel = Label(self, text="Set Outside Temp Tomorow: ", font=SFONT, bg=CY, fg=SN)
        outLabel.pack()
        outField = Entry(self, width=1)
        outField.pack(pady=3, padx=5, ipadx=10)
        outField.focus_set()

        acLabel = Label(self, text="Set AC Temp Tomorow: ", font=SFONT, bg=CY , fg=SN)
        acLabel.pack()
        acField = Entry(self, width=1)
        acField.pack(pady=3, padx=5, ipadx=10)

        checkbutton = Button(self, text="Check From Input", font=SFONT, bg=DO, fg=SN, width=15, 
                                        command=lambda:check_pred(outField.get(), acField.get()))  
        bmkgButton = Button(self, text="Check Based BMKG", font=SFONT, bg=DO, fg=SN, width=15,
                                        command=lambda:check_pred("", "", "bmkg"))
        checkbutton.pack(pady=2)
        bmkgButton.pack(pady=2)

        empty = Label(self, text="", font=LFONT, bg=CY)
        resultValue = Label(self, text="", font=SFONT, bg=SN)

        def check_pred(out, ac, str=""):
            if str == "bmkg":
                if Predict().predict('', '', 'bmkg') == 0:
                    empty.config(text="No Connection!!!")   
                    empty.pack()
                    clear()
                    empty.after(3000, disappear)
                else:
                    resultValue.forget()
                    clear()
                    resultValue.config(text=f"Predicted Temp based BMKG: {Predict().predict('', '', 'bmkg'):.2f}°C")
                    resultValue.pack()
            else:
                if ac == "" or out == "":
                    empty.pack()
                    empty.config(text="Please Fill All Field!!!")
                    clear()
                    empty.after(3000, disappear)
                else:
                    try:
                        out = float(out)
                        ac = float(ac)
                        resultValue.forget()
                        resultValue.config(text=f"Predicted Temp based User: {Predict().predict(out, ac, ''):.2f}°C")
                        resultValue.pack()
                    except:
                        empty.pack()
                        empty.config(text="Please Fill With Number!!!")
                        clear()
                        empty.after(3000, disappear)                    

        def disappear():
            empty.forget()

        def clear():
            acField.delete(0, END)
            outField.delete(0, END)

if __name__ == "__main__":
    app = GUIBuild()
    app.title("Prediksi")
    app.mainloop()