USE `ebenta`;

-- Update seller business names and descriptions to San Carlos City & Pangasinan circular tech hubs
UPDATE `ebenta`.`users`
SET
    `business_name` = CASE (id % 20)
        WHEN 0 THEN 'San Carlos Tech Recovery & E-Scrap Solutions'
        WHEN 1 THEN 'Palaris Component Traders & Computer Salvage'
        WHEN 2 THEN 'Binalatongan Hardware Exchangers'
        WHEN 3 THEN 'Pangasinan Green Silicon & Laptop Depot'
        WHEN 4 THEN 'Agdao Computer Parts & E-Waste Exchange'
        WHEN 5 THEN 'Central Pangasinan Tech Recyclers'
        WHEN 6 THEN 'Turac Electronics Salvage & Refurbishment'
        WHEN 7 THEN 'Rizal Avenue MicroTech Solutions'
        WHEN 8 THEN 'Pangasinan Circular Hardware Trading'
        WHEN 9 THEN 'San Carlos EcoByte Component Center'
        WHEN 10 THEN 'North Luzon E-Scrap Depot - San Carlos Branch'
        WHEN 11 THEN 'Coliling Tech Scrap & Circuit Lab'
        WHEN 12 THEN 'Mabini Computer Salvage & Parts Hub'
        WHEN 13 THEN 'Pangasinan E-Benta Salvage Center'
        WHEN 14 THEN 'San Carlos CircuitWorks & Hardware Recovery'
        WHEN 15 THEN 'Perez Blvd. Digital Scrap & Refurbishing'
        WHEN 16 THEN 'Talang Green Hardware Trading'
        WHEN 17 THEN 'Pangasinan Silicon Cycle Workshop'
        WHEN 18 THEN 'Bugallon-Posadas Tech Salvage'
        ELSE 'Bocboc Electronic Waste & Scrap Hub'
    END,
    `business_description` = CASE (id % 20)
        WHEN 0 THEN 'Leading Pangasinan e-waste collection center specializing in circuit board recovery, tested repairable units, and eco-friendly component disposal in San Carlos City.'
        WHEN 1 THEN 'Trusted San Carlos City scrap and hardware trading hub. We buy salvage laptops, server racks, and office desktop units across central Pangasinan.'
        WHEN 2 THEN 'Historic Binalatongan circular tech dealer providing tested motherboards, refurbished power supplies, and component-level electronics recycling.'
        WHEN 3 THEN 'Eco-certified electronics refurbishment workshop in San Carlos City. Specializing in corporate laptop upgrades, RAM/SSD harvesting, and scrap salvage.'
        WHEN 4 THEN 'Community e-waste drop-off and component salvage partner in San Carlos City, Pangasinan. Promoting circular electronics since 2023.'
        WHEN 5 THEN 'Bulk e-waste aggregators serving San Carlos City, Calasiao, and Malasiqui. Licensed electronic scrap recovery and eco-footprint reporting.'
        WHEN 6 THEN 'Harvesting functional chips, screens, and copper components from decommissioned office tech in San Carlos City.'
        WHEN 7 THEN 'Downtown San Carlos City computer repair, display panel reclamation, and responsible e-waste dismantling facility.'
        WHEN 8 THEN 'Purchasing bulk salvage, repairable PCs, and defective electronics for sustainable recovery across the province of Pangasinan.'
        WHEN 9 THEN 'Certified repair and electronics recycling facility in San Carlos City. Refurbishing business-grade ThinkPads, monitors, and harvested parts.'
        WHEN 10 THEN 'Regional tech recycling point handling municipal and commercial e-scrap, power supplies, and printed circuit board segregation.'
        WHEN 11 THEN 'Specialized component testing, solder reclamation, and safe battery disposal in San Carlos City, Pangasinan.'
        WHEN 12 THEN 'Local San Carlos tech recycler providing tested working processors, power adapters, and certified eco-disposal.'
        WHEN 13 THEN 'Dedicated platform seller for recovered electronic components, salvage bulk lots, and certified green recycling certificates.'
        WHEN 14 THEN 'Professional hardware triage, logic board component harvesting, and green electronics supply for Pangasinan.'
        WHEN 15 THEN 'San Carlos City center for tested DDR3/DDR4 memory, refurbished LCD displays, and safe e-waste segregation.'
        WHEN 16 THEN 'Eco-conscious e-waste trader and parts reclaimer serving San Carlos City and nearby Pangasinan municipalities.'
        WHEN 17 THEN 'Transforming discarded corporate tech and scrap electronics into tested, reusable computer hardware in San Carlos City.'
        WHEN 18 THEN 'Poblacion-based e-waste recovery shop buying decommissioned office desktops, laptop batteries, and copper wiring.'
        ELSE 'Licensed electronics dismantler and circular materials vendor operating in San Carlos City, Pangasinan.'
    END
WHERE `role` = 'seller';
