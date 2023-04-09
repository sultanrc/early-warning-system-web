var value = JSON.parse(JSON.stringify(msg.payload));
value = msg;

var d = new Date();
var year = d.getFullYear();
var month = ('0' + (d.getMonth() + 1)).slice(-2);
var day = ('0' + d.getDate()).slice(-2);
var date = year + "-" + month + "-" + day;
var hours = ('0' + d.getHours()).slice(-2);
var minutes = ('0' + d.getMinutes()).slice(-2);
var seconds = ('0' + d.getSeconds()).slice(-2);
var time = hours + ":" + minutes + ":" + seconds;

var sensor1 = msg.payload.Temp;
var sensor2 = msg.payload.Hum;
var sensor3 = msg.payload.Fire;
msg.payload = [date, time, sensor1, sensor2, sensor3];
msg.topic = 'INSERT INTO ews_table(date, time, temp, hum, fa) VALUES (?,?,?,?,?);';
return msg; 
