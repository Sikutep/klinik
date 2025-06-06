<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Obat;

class ObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $obats = [
            "Paracetamol", "Ibuprofen", "Aspirin", "Diclofenac", "Naproxen", "Ketorolac",
            "Indomethacin", "Morphine", "Fentanyl", "Codeine", "Oxycodone", "Hydrocodone",
            "Tramadol", "Buprenorphine", "Methadone", "Celecoxib", "Meloxicam", "Piroxicam",
            "Ketoprofen", "Tapentadol", "Amoxicillin", "Amoxicillin-Clavulanate", "Azithromycin",
            "Clarithromycin", "Erythromycin", "Doxycycline", "Tetracycline", "Ciprofloxacin",
            "Levofloxacin", "Moxifloxacin", "Ofloxacin", "Cefalexin", "Cefuroxime", "Ceftriaxone",
            "Cefixime", "Ceftazidime", "Cefepime", "Clindamycin", "Metronidazole", "Vancomycin",
            "Amlodipine", "Lisinopril", "Losartan", "Valsartan", "Enalapril", "Ramipril", "Captopril",
            "Metoprolol", "Atenolol", "Propranolol", "Carvedilol", "Bisoprolol", "Nebivolol",
            "Diltiazem", "Verapamil", "Hydralazine", "Clonidine", "Methyldopa", "Nifedipine",
            "Spironolactone", "Metformin", "Glipizide", "Glibenclamide", "Glimepiride", "Sitagliptin",
            "Saxagliptin", "Linagliptin", "Insulin Glargine", "Insulin Aspart", "Insulin Lispro",
            "Pioglitazone", "Rosiglitazone", "Acarbose", "Miglitol", "Empagliflozin", "Canagliflozin",
            "Dapagliflozin", "Repaglinide", "Liraglutide", "Dulaglutide", "Acyclovir", "Valacyclovir",
            "Famciclovir", "Oseltamivir", "Zanamivir", "Remdesivir", "Ribavirin", "Sofosbuvir",
            "Ledipasvir", "Tenofovir", "Lamivudine", "Zidovudine", "Efavirenz", "Nevirapine",
            "Ritonavir", "Lopinavir", "Atazanavir", "Darunavir", "Dolutegravir", "Raltegravir",
            "Fluoxetine", "Sertraline", "Paroxetine", "Escitalopram", "Citalopram", "Venlafaxine",
            "Duloxetine", "Amitriptyline", "Nortriptyline", "Bupropion", "Mirtazapine", "Haloperidol",
            "Risperidone", "Olanzapine", "Quetiapine", "Aripiprazole", "Clozapine", "Ziprasidone",
            "Lurasidone", "Lithium", "Omeprazole", "Pantoprazole", "Lansoprazole", "Esomeprazole",
            "Rabeprazole", "Famotidine", "Ranitidine", "Sucralfate", "Misoprostol", "Domperidone",
            "Ondansetron", "Metoclopramide", "Bisacodyl", "Docusate", "Loperamide",
            "Bismuth Subsalicylate", "Rifaximin", "Mesalazine", "Sulfasalazine", "Prednisone",
            "Salbutamol", "Ipratropium", "Tiotropium", "Formoterol", "Salmeterol", "Fluticasone",
            "Budesonide", "Montelukast", "Theophylline", "Mometasone", "Beclomethasone",
            "Fluticasone Propionate", "Fluticasone Furoate", "Flunisolide", "Cromolyn Sodium",
            "Zafirlukast", "Omalizumab", "Budesonide/Formoterol", "Fluticasone/Salmeterol",
            "Prednisolone", "Hydrocortisone", "Triamcinolone", "Clobetasol", "Betamethasone",
            "Fluocinonide", "Mupirocin", "Neomycin", "Clotrimazole", "Ketoconazole", "Terbinafine",
            "Permethrin", "Benzoyl Peroxide", "Salicylic Acid", "Isotretinoin", "Tretinoin",
            "Adapalene", "Tacrolimus", "Pimecrolimus", "Minocycline", "Azelaic Acid",
            "Chlorpheniramine", "Diphenhydramine", "Loratadine", "Fexofenadine", "Cetirizine",
            "Digoxin", "Warfarin", "Heparin", "Enoxaparin", "Clopidogrel", "Ticagrelor",
            "Prasugrel", "Dipyridamole", "Apixaban", "Rivaroxaban", "Dabigatran", "Atropine",
            "Scopolamine", "Nitrofurantoin", "Hydroxychloroquine"
        ];

        foreach ($obats as $nama) {
            Obat::firstOrCreate(['nama' => $nama]);
        }
    }
}
