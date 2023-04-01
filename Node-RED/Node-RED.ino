#include <DHT.h>
#include <LiquidCrystal_I2C.h>  //Library For
#define SENSORPIN D5 //Deklarasi sensor api pada pin D5
#define DHT11PIN D7 //Deklarasi sensor suhu dan kelembaban pada pin D7
#define DHTTYPE DHT11 //Deklarasi tipe sensor DHT11

DHT dht(DHT11PIN, DHTTYPE, 15);
LiquidCrystal_I2C lcd(0x27, 20, 2);  // CHANGE THE 0X27 ADDRESS TO YOUR SCREEN ADDRESS IF NEEDED

float humidity = 0;
float temprature = 0;
float firedity = 0;
int readsensor = 0;

void setup() {
  Serial.begin(9600);
  dht.begin();
  lcd.begin(16, 2);
  lcd.init();
  lcd.backlight();
}

void showDatainLCD(float Humidity, float Temperature){
  lcd.clear();
  lcd.print("TEMP  : ");
  lcd.print(Temperature);
  lcd.print((char)223);
  lcd.print("C");
  lcd.setCursor(0, 1);
  lcd.print("HUMID : ");
  lcd.print(Humidity);
  lcd.print("%");
}

void loop() {
  temprature = dht.readTemperature();
  humidity = dht.readHumidity();

  showDatainLCD(humidity, temprature);

  //blok kode untuk mengecek sensor api
  int i = 0;
  firedity = 0;
  while(i<30){ //0 = fire, 1 = no fire
    readsensor = digitalRead(SENSORPIN);
    if (readsensor == 1){
      delay(10000);
      i++;
      continue;
    }
    firedity = 1;
    break;
  }

  temprature = dht.readTemperature();
  humidity = dht.readHumidity();

  //blok kode untuk mengirim data ke Node-RED
  Serial.print("{\"Hum\":");
  Serial.print(humidity);
  Serial.print(",\"Temp\":");
  Serial.print(temprature);
  Serial.print(",\"Fire\":");
  Serial.print(firedity);
  Serial.println("}");

  if (readsensor == 0) delay (3000);
}
