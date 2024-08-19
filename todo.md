todo today:

setup dashboard untuk ibu dan dokter pake vue

# 2024-08-02
    Buat fitur Checkup:
    requirements:
        - can handle mother and children checkup with different sets of data.
        - come from one component: checkup, whick search the guid of mother or children
        - anak:
            - 

    - staff id and hospital id belum terisi ketika input pregnancy checkup history
    - input nya juga masih text semua, harusnya ada yang upload, ada yang calendar
    - Checkup history harus handle juga anak dan hanya memunculkan yang staff_id == current user

# 2024-08-16:
    input ke users sekalian input ke staff
    - yang di input di staff, name nya samain.
    - tapi kita juga butuh input hospital_id, jabatan_role, (nip)
    what to do :
        - bisa di model
        - bisa di event
        - tapi dua2 nya, butuh akses ke request, caranya gmna?
        

Notes:
•⁠  ⁠catatan kesehatan ibu cm muncul satu data aja, harsnya multiple (harris)✅ (pregnancy_history) (search bar belum)
-⁠  ⁠evaluasi kehamilan grafik belum by database (DELETE) miftah (belum)
•⁠  ⁠
riwayat persalinan blm bisa disave, dan harusnya bisa nambahin dan bisa liat riwayat persalinan dia (teguh) ✅
        -   (kehamilan ke) ga ada di input field
        -   hari pertama haid terakhir tanggal doang di db, 
        - lingkar lengan atas ada dua inputan

•⁠  ⁠profile masi bug (harris)✅

•⁠  ⁠qr belum by profile, dan dibuat langsung url checkup (teguh) ✅
•⁠  ⁠stunting_chart to public url sblm login (teguh) ✅

•⁠  ubah semua url yang ke 'dashboard' balik ke 'home' ( Miftah )
•⁠  ⁠add NIP to Tenaga medis (miftah    )  ( tinggal masukan ke resource user ) ( Miftah )

•⁠  ⁠input user sekalian masuk ke tenaga medis (teguh)  ✅
•⁠  ⁠Check up history filter by tenaga medis (miftah)  ✅