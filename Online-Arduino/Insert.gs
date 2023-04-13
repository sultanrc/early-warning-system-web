function myFunction() {
  var sheet_id = ''; 		// Spreadsheet ID
  var sheet = SpreadsheetApp.openById(sheet_id).getActiveSheet();		// get Active sheet
  var data = sheet.getDataRange().getValues();

  var server = "";
  var dbName = "";
  var username = "";
  var password = "";
  var port = 3306;
  var url = "jdbc:mysql://"+server+":"+port+"/"+dbName;
  var conn = Jdbc.getConnection(url, username, password);
  var stmt = conn.prepareStatement("INSERT INTO ews_table (date, time, temp, hum, fa) VALUES (?, ?, ?, ?, ?)");

  for (var i = 0; i < data.length; i++) {
    if (data[i][5] == 0){
      sheet.getRange("F1").setValue(1);
      var d = new Date(data[i][0])
      stmt.setString(1, d.getFullYear()+"-"+('0' + (d.getMonth() + 1)).slice(-2)+"-"+('0' + d.getDate()).slice(-2));
      stmt.setString(2, data[i][1].replace(/\./g, ":"));
      stmt.setString(3, data[i][2]);
      stmt.setString(4, data[i][3]);
      stmt.setString(5, data[i][4]);
      try{
        stmt.execute();
        Logger.log("Inserted into database.");
      } catch (error){
        Logger.log(error);
      }
    } else {
      Logger.log("The Data Has Inserted to The Database");
    }
  }
  stmt.close();
  conn.close();
}
