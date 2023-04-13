function doGet(e) { 
  Logger.log( JSON.stringify(e) );  // view parameters
  var result = 'Ok'; // assume success
  if (e.parameter == 'undefined') {
    result = 'No Parameters';
  }
  else {
    var sheet_id = ''; 		// Spreadsheet ID
    var sheet = SpreadsheetApp.openById(sheet_id).getActiveSheet();		// get Active sheet
    var newRow = sheet.getLastRow();						
    var rowData = [];
    d=new Date();
    rowData[0] = d;
    rowData[1] = d.toLocaleTimeString();

    for (var param in e.parameter) {
      Logger.log('In for loop, param=' + param);
      var value = stripQuotes(e.parameter[param]);
      Logger.log(param + ':' + e.parameter[param]);
      switch (param) {
        case 'value1': //Parameter 1, It has to be updated in Column in Sheets in the code, orderwise
          rowData[2] = value; //Value in column C
          result = 'Written on column C';
          break;
        case 'value2': //Parameter 2, It has to be updated in Column in Sheets in the code, orderwise
          rowData[3] = value; //Value in column D
          result += ' Written on column D';
          break;
        case 'value3': //Parameter 3, It has to be updated in Column in Sheets in the code, orderwise
          rowData[4] = value; //Value in column E
          result += ' Written on column E';
          break;
  
        default:
          result = "unsupported parameter";
      }
    }
    rowData[5] = 0;
    Logger.log(JSON.stringify(rowData));
    // Write new row below
    var newRange = sheet.getRange(newRow, 1, 1, rowData.length);
    newRange.setValues([rowData]);

    var emailAddress = "emailtesarduino@gmail.com";
    if (rowData[4] == 1) {
      MailApp.sendEmail(emailAddress, "Api Terdektesi!", "Sensor Mendeteksi Kemungkinan Adanya API \nSegera untuk mengecek ruangan! \nSensor Akan Pending dalam 10 Menit Kedepan");
    } else if (rowData[2] > 24) {
      MailApp.sendEmail(emailAddress, "Sensor Mendeteksi Suhu Server lebih dari 24°C", rowData[2]); 
    }
  }
  // Return result of operation
  return ContentService.createTextOutput(result);
}
function stripQuotes( value ) {
  return value.replace(/^["']|['"]$/g, "");
}
