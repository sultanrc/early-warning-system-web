-Pembuatan aplikasi [DONE]
  - Dashboard
  - Reporting
-Penggunaan instrumentasi [DONE]
-Data analisis [DONE]
  - Data Pre-processing
      - Data cleansing
-Membangun model [DONE]

1. Dapat melakukan pengukuran menggunakan sensor. [DONE]
2. Dapat melakukan pengumpulan data. [DONE]
3. Dapat melakukan pengolahan data. [DONE]
4. Dapat melakukan analisis data. [DONE]
5. Kesimpulan dan saran (dalam pandangan bisnis, benefit system). [IN PROGRESS]


<script>
    function checkForm() {
        var suhu_luar_besok = document.getElementById("suhu_luar_besok").value;
        var suhu_ac_besok = document.getElementById("suhu_ac_besok").value;
        if (suhu_luar_besok == "" || suhu_ac_besok == "") {
            alert("Please fill the input first");
            return false;
        }
        return true;
    }
    </script>
