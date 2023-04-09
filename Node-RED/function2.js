var value = JSON.parse(JSON.stringify(msg.payload));
value = msg;

if (msg.payload.Fire == 1){
    msg.payload = "Ada Api";
    return [msg, null];
} else if (msg.payload.Temp > 24) {
    msg.payload = "Suhu Gede";
    return[msg, null];
}

return msg;
