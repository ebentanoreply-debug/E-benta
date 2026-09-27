USE `ebenta`;

-- Update all existing users to San Carlos City, Pangasinan (Postal Code 2420)
-- Distributes realistic San Carlos City barangays, puroks, and authentic street addresses across records.

UPDATE `ebenta`.`users`
SET 
    `address_city` = 'San Carlos City',
    `address_province` = 'Pangasinan',
    `postal_code` = '2420',
    `barangay` = CASE (id % 30)
        WHEN 0 THEN 'Brgy. Palaris'
        WHEN 1 THEN 'Brgy. Rizal'
        WHEN 2 THEN 'Brgy. Mabini'
        WHEN 3 THEN 'Brgy. Bugallon-Posadas'
        WHEN 4 THEN 'Brgy. Lucban'
        WHEN 5 THEN 'Brgy. Padilla'
        WHEN 6 THEN 'Brgy. Talang'
        WHEN 7 THEN 'Brgy. Coliling'
        WHEN 8 THEN 'Brgy. Turac'
        WHEN 9 THEN 'Brgy. Agdao'
        WHEN 10 THEN 'Brgy. Abanon'
        WHEN 11 THEN 'Brgy. Bocboc'
        WHEN 12 THEN 'Brgy. Mamarlao'
        WHEN 13 THEN 'Brgy. Tarece'
        WHEN 14 THEN 'Brgy. Magtaking'
        WHEN 15 THEN 'Brgy. Baldog'
        WHEN 16 THEN 'Brgy. Pagal'
        WHEN 17 THEN 'Brgy. Capandanan'
        WHEN 18 THEN 'Brgy. Balococ'
        WHEN 19 THEN 'Brgy. Tamayo'
        WHEN 20 THEN 'Brgy. Tandoc'
        WHEN 21 THEN 'Brgy. Caoayan Kiling'
        WHEN 22 THEN 'Brgy. Ilang'
        WHEN 23 THEN 'Brgy. San Pedro-Taloy'
        WHEN 24 THEN 'Brgy. Antipangol'
        WHEN 25 THEN 'Brgy. Bacnar'
        WHEN 26 THEN 'Brgy. Balite Sur'
        WHEN 27 THEN 'Brgy. Bega'
        WHEN 28 THEN 'Brgy. Dalandan'
        ELSE 'Brgy. Gamata'
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
