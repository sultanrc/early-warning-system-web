# Service Flow using Node-Red to receive input from arduino then insert to the database and send email if some condition is true
![image](https://user-images.githubusercontent.com/74691228/231653546-04feb255-c9ae-4d39-8be0-8c52212f4c86.png)

## Config Flow
Before proceeding with the configuration, make sure that node red is installed.
1. Install Palette in Manage Palette
![image](https://user-images.githubusercontent.com/74691228/231656935-529c0467-2229-47f7-9466-9cfa99acf846.png)
2. In the network node select serial in and set the Serial Port to match the USB cable port that is connected to the laptop/PC as an example: "Board .... Port COM3"  be seen in the Arduino IDE then set the Baud Rate to Serial.begin which is used in the arduino code as an example: "Serial.begin(9600);"
![image](https://user-images.githubusercontent.com/74691228/231654032-1855f513-d549-49e8-8ac4-deb9bcb7d904.png)
3. In the parser node select JSON and adjust to the iamge below
![image](https://user-images.githubusercontent.com/74691228/231658893-8cbbee45-c659-4343-85bb-f6ce17d0f8f7.png)
4. In the function node select two node (u also can see the code function in file json above)
   - First Node Function to returns the data read then insert to the database
   - Second Node Function to read and check the datas if the condtion true then return an message to send an email
5. Last select mysql in storage node and email (send) in social node then config it (for the sender's password, use the password app created in the email)
