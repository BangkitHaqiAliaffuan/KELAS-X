BEGIN
    DaftarSiswa = []
    
    WHILE TRUE DO
        INPUT NamaSiswa
        INPUT JumlahMataPelajaran
        TotalNilai = 0
        
        FOR i = 1; i < JumlahMataPelajaran; i++
                INPUT Nilai[i]
                
                IF Nilai[i] >= 0 AND Nilai[i] <= 100
                    
                    TotalNilai = TotalNilai + Nilai[i]
                
                ELSE
                    
        ENDFOR
        
        RataRata ← TotalNilai / JumlahMataPelajaran
        
        IF RataRata >= 85 THEN
            Grade ← "A"
        ELSE IF RataRata >= 70 THEN
            Grade ← "B"
        ELSE IF RataRata >= 60 THEN
            Grade ← "C"
        ELSE IF RataRata >= 50 THEN
            Grade ← "D"
        ELSE
            Grade ← "E"
        ENDIF
        
        IF RataRata >= 60 THEN
            Status ← "Lulus"
        ELSE
            Status ← "Tidak Lulus"
        ENDIF
        
        DataSiswa ← {
            "Nama": NamaSiswa,
            "Nilai": Nilai[],
            "RataRata": RataRata,
            "Grade": Grade,
            "Status": Status
        }
        
        APPEND DataSiswa TO DaftarSiswa
        
        OUTPUT "Nama Siswa: " + NamaSiswa
        OUTPUT "Nilai: " + Nilai[]
        OUTPUT "Rata-Rata: " + RataRata
        OUTPUT "Grade: " + Grade
        OUTPUT "Status: " + Status
        
        OUTPUT "Pilih opsi:"
        OUTPUT "1. Input siswa lain"
        OUTPUT "2. Lihat riwayat"
        OUTPUT "3. Keluar"
        INPUT Pilihan
        
        IF Pilihan = 2 THEN
            FOR EACH Siswa IN DaftarSiswa DO
                OUTPUT Siswa
            ENDFOR
        ELSE IF Pilihan = 3 THEN
            BREAK
        ENDIF
    ENDWHILE
END
