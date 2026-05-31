<?php
$categories = [
    [
        'id' => 3,
        'name' => 'Eye Drop',
        'slug' => 'eye-drop',
        'image' => 'assets/categories/eye-drop.jpeg'
    ],
    [
        'id' => 4,
        'name' => 'MouthWash',
        'slug' => 'mouthwash',
        'image' => 'assets/categories/mouthwash.png'
    ],
    [
        'id' => 6,
        'name' => 'Syrups',
        'slug' => 'syrups',
        'image' => 'assets/categories/syrups.jpeg'
    ],
    [
        'id' => 5,
        'name' => 'Tablets',
        'slug' => 'tablets',
        'image' => 'assets/categories/tablets.jpeg'
    ]
];

// Static products (matching SQL IDs, slugs, compositions, uses, dosages, storage, etc.)
$products = [
    [
        'id' => 2,
        'category_id' => 4,
        'name' => 'Alkadent+',
        'slug' => 'alkadent',
        'image' => 'assets/products/alkadent.png',
        'additional_images' => null,
        'composition' => "Chlorhexidine Gluconate(0.2%),Sodium Fluoride(0.05%),Zinc Chloride(0.09%),Peppermint Extract",
        'uses' => "1. Strengthens enamel and reduces plaque buildup.\n2. Suitable for adults and teens aged 12 and above.\n3. Alcohol Free Formula - safe for sensitive mouths.\n4. Kills 99.9% of germs with every Rinse.",
        'dosage' => "Designed for everyday Use.\nProcedure:\n1. Pour 20ml\n2. Rinse 30sec\n3. Spit Out\n4. Wait 30 min",
        'safety_information' => null,
        'storage' => null,
        'manufacturer_details' => "Manufactured By Maascure Pharmaceutical Private Limited.",
        'brochure' => null,
        'badge' => null
    ],
    [
        'id' => 3,
        'category_id' => 3,
        'name' => 'Optirelief',
        'slug' => 'optirelief',
        'image' => 'assets/products/optirelief.jpeg',
        'additional_images' => null,
        'composition' => "Carboxymethyl Cellulose-1% (w/v)",
        'uses' => "Relieves the symptoms of dry, irritated eyes.\nIt lubricates, hydrates and contributes to tear regeneration.",
        'dosage' => "As directed by the Physician.",
        'safety_information' => null,
        'storage' => "Store in cool Place.\nProtect from Light.\nDo not freeze.\nKeep out of reach of children.",
        'manufacturer_details' => "Mannufactured by Maascure Pharmaceutical Pvt. Limited.",
        'brochure' => null,
        'badge' => null
    ],
    [
        'id' => 4,
        'category_id' => 3,
        'name' => 'Oculocef',
        'slug' => 'oculocef',
        'image' => 'assets/products/oculocef.png',
        'additional_images' => null,
        'composition' => null,
        'uses' => "Broad Spectrum Antibiotic Eye Drop",
        'dosage' => "As directed by Ophthalmologist.",
        'safety_information' => null,
        'storage' => "Store below 25'C.",
        'manufacturer_details' => "Mannufactured by Maascure Pharmaceutical Pvt. Limited.",
        'brochure' => null,
        'badge' => null
    ],
    [
        'id' => 5,
        'category_id' => 5,
        'name' => 'Cefmocure',
        'slug' => 'cefmocure',
        'image' => 'assets/products/cefmocure.png',
        'additional_images' => null,
        'composition' => "Cefixime 200mg",
        'uses' => "Broad Spectrum Antibiotic.",
        'dosage' => "As directed by Physician.",
        'safety_information' => null,
        'storage' => null,
        'manufacturer_details' => "Mannufactured by Maascure Pharmaceutical Pvt. Limited.",
        'brochure' => null,
        'badge' => null
    ],
    [
        'id' => 6,
        'category_id' => 5,
        'name' => 'Cap Q10',
        'slug' => 'cap-q10',
        'image' => 'assets/products/cap-q10.jpeg',
        'additional_images' => null,
        'composition' => null,
        'uses' => "Energy, Immunity, Heart Health, Overall Wellness",
        'dosage' => null,
        'safety_information' => null,
        'storage' => null,
        'manufacturer_details' => "Manufactured by Maascure Pharmaceutical Pvt. Limited.",
        'brochure' => null,
        'badge' => null
    ],
    [
        'id' => 7,
        'category_id' => 5,
        'name' => 'Hepatovex',
        'slug' => 'hepatovex',
        'image' => 'assets/products/hepatovex.png',
        'additional_images' => null,
        'composition' => "Vitamin B12",
        'uses' => "1. Reduces Liver Fat\n2. Promotes Regeneration\n3. Protects Liver Cells\n4. Improves Metabolism",
        'dosage' => "As per the Physician.",
        'safety_information' => "Protect from direct sunlight\nKeep out of reach of the children",
        'storage' => "Store in a cool, dry place.",
        'manufacturer_details' => "Mannufactured by Maascure Pharmaceutical Pvt. Limited.",
        'brochure' => null,
        'badge' => null
    ]
];
