USE `ebenta`;

-- Update all existing users to San Carlos City, Pangasinan (Postal Code 2420)
-- Distributes realistic San Carlos City barangays, puroks, and authentic street addresses across records.

UPDATE `ebenta`.`users`
SET 
    `address_city` = 'San Carlos City',
    `address_province` = 'Pangasinan',
    `postal_code` = '2420',
    `barangay` = CASE (id % 30)
        WHEN 0 THEN 'Palaris'
        WHEN 1 THEN 'Rizal'
        WHEN 2 THEN 'Mabini'
        WHEN 3 THEN 'Bugallon-Posadas'
        WHEN 4 THEN 'Lucban'
        WHEN 5 THEN 'Padilla'
        WHEN 6 THEN 'Talang'
        WHEN 7 THEN 'Coliling'
        WHEN 8 THEN 'Turac'
        WHEN 9 THEN 'Agdao'
        WHEN 10 THEN 'Abanon'
        WHEN 11 THEN 'Bocboc'
        WHEN 12 THEN 'Mamarlao'
        WHEN 13 THEN 'Tarece'
        WHEN 14 THEN 'Magtaking'
        WHEN 15 THEN 'Baldog'
        WHEN 16 THEN 'Pagal'
        WHEN 17 THEN 'Capandanan'
        WHEN 18 THEN 'Balococ'
        WHEN 19 THEN 'Tamayo'
        WHEN 20 THEN 'Tandoc'
        WHEN 21 THEN 'Caoayan Kiling'
        WHEN 22 THEN 'Ilang'
        WHEN 23 THEN 'San Pedro-Taloy'
        WHEN 24 THEN 'Antipangol'
        WHEN 25 THEN 'Bacnar'
        WHEN 26 THEN 'Balite Sur'
        WHEN 27 THEN 'Bega'
        WHEN 28 THEN 'Dalandan'
        ELSE 'Gamata'
    END,
    `address_line_1` = CASE (id % 30)
        WHEN 0 THEN '14 Palaris Street'
        WHEN 1 THEN '88 Rizal Avenue'
        WHEN 2 THEN '25 Perez Boulevard'
        WHEN 3 THEN '42 Mabini Street'
        WHEN 4 THEN '52 Bugallon-Posadas Street'
        WHEN 5 THEN '19 Montemayor Street'
        WHEN 6 THEN '31 Gomez Street'
        WHEN 7 THEN '76 Roxas Boulevard'
        WHEN 8 THEN 'Purok 1, San Carlos-Calasiao Road'
        WHEN 9 THEN 'Purok 2, San Carlos-Calasiao Road'
        WHEN 10 THEN 'Purok 3, San Carlos-Malasiqui Road'
        WHEN 11 THEN 'Purok 4, San Carlos-Malasiqui Road'
        WHEN 12 THEN 'Purok 1, San Carlos-Aguilar Road'
        WHEN 13 THEN 'Purok 2, San Carlos-Basista Road'
        WHEN 14 THEN 'Sitio Centro, Coliling Road'
        WHEN 15 THEN 'Purok 4, Turac Highway'
        WHEN 16 THEN 'Purok 1, Agdao Proper'
        WHEN 17 THEN 'Sitio Riverside, Abanon'
        WHEN 18 THEN 'Purok 3, Bocboc Proper'
        WHEN 19 THEN 'Block 5 Lot 12, Villa San Carlos Subd.'
        WHEN 20 THEN 'Block 2 Lot 8, Doña Maria Subdivision'
        WHEN 21 THEN 'Block 9 Lot 14, San Carlos Heights'
        WHEN 22 THEN 'Purok 5, Tarece Road'
        WHEN 23 THEN 'Sitio Centro Norte, Pagal'
        WHEN 24 THEN 'Purok 1, Capandanan'
        WHEN 25 THEN 'Purok 3, Balococ'
        WHEN 26 THEN 'Purok 6, Tamayo Road'
        WHEN 27 THEN 'Purok 2, Tandoc'
        WHEN 28 THEN 'Purok 4, Caoayan Kiling'
        ELSE 'Purok 2, Baldog'
    END;
