<?php

namespace Softzino\EmployeeManagement\Database\Seeders;

use Illuminate\Database\Seeder;
use Softzino\EmployeeManagement\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            ['Bangladesh', 'BD', 'BGD', '+880', '^\\+880[1-9]\\d{8}$', 'BDT', '৳', 'Asia/Dhaka', 'Bangladeshi Taka'],
            ['Afghanistan', 'AF', 'AFG', '+93', '^\\+93[1-9]\\d{8}$', 'AFN', '؋', 'Asia/Kabul', 'Afghan Afghani'],
            ['Argentina', 'AR', 'ARG', '+54', '^\\+54[1-9]\\d{8}$', 'ARS', '$', 'America/Argentina/Buenos_Aires', 'Argentine Peso'],
            ['Australia', 'AU', 'AUS', '+61', '^\\+61[1-9]\\d{8}$', 'AUD', '$', 'Australia/Sydney', 'Australian Dollar'],
            ['Belgium', 'BE', 'BEL', '+32', '^\\+32[1-9]\\d{8}$', 'EUR', '€', 'Europe/Brussels', 'Euro'],
            ['Brazil', 'BR', 'BRA', '+55', '^\\+55[1-9]\\d{8}$', 'BRL', 'R$', 'America/Sao_Paulo', 'Brazilian Real'],
            ['Canada', 'CA', 'CAN', '+1', '^\\+1[2-9]\\d{2}[2-9]\\d{2}\\d{4}$', 'CAD', '$', 'America/Toronto', 'Canadian Dollar'],
            ['China', 'CN', 'CHN', '+86', '^\\+86[1-9]\\d{9}$', 'CNY', '¥', 'Asia/Shanghai', 'Chinese Yuan'],
            ['Czech Republic', 'CZ', 'CZE', '+420', '^\\+420[1-9]\\d{8}$', 'CZK', 'Kč', 'Europe/Prague', 'Czech Koruna'],
            ['Denmark', 'DK', 'DNK', '+45', '^\\+45[1-9]\\d{8}$', 'DKK', 'kr', 'Europe/Copenhagen', 'Danish Krone'],
            ['Djibouti', 'DJ', 'DJI', '+253', '^\\+253[1-9]\\d{6}$', 'DJF', 'Fdj', 'Africa/Djibouti', 'Djiboutian Franc'],
            ['Dominica', 'DM', 'DMA', '+1-767', '^\\+1-767\\d{7}$', 'XCD', '$', 'America/Dominica', 'East Caribbean Dollar'],
            ['Dominican Republic', 'DO', 'DOM', '+1-809', '^\\+1-809\\d{7}$', 'DOP', 'RD$', 'America/Santo_Domingo', 'Dominican Peso'],
            ['Ecuador', 'EC', 'ECU', '+593', '^\\+593[1-9]\\d{7}$', 'USD', '$', 'America/Guayaquil', 'United States Dollar'],
            ['Egypt', 'EG', 'EGY', '+20', '^\\+20[1-9]\\d{8}$', 'EGP', '£', 'Africa/Cairo', 'Egyptian Pound'],
            ['El Salvador', 'SV', 'SLV', '+503', '^\\+503[1-9]\\d{6}$', 'SVC', '$', 'America/El_Salvador', 'Salvadoran Colón'],
            ['Equatorial Guinea', 'GQ', 'GNQ', '+240', '^\\+240[1-9]\\d{6}$', 'GNF', 'Fr', 'Africa/Malabo', 'Central African CFA Franc'],
            ['Eritrea', 'ER', 'ERI', '+291', '^\\+291[1-9]\\d{6}$', 'ERN', 'Nfk', 'Africa/Asmara', 'Eritrean Nakfa'],
            ['Estonia', 'EE', 'EST', '+372', '^\\+372[1-9]\\d{7}$', 'EEK', 'kr', 'Europe/Tallinn', 'Estonian Kroon'],
            ['Eswatini', 'SZ', 'SWZ', '+268', '^\\+268[1-9]\\d{6}$', 'SZL', 'L', 'Africa/Mbabane', 'Swazi Lilangeni'],
            ['Ethiopia', 'ET', 'ETH', '+251', '^\\+251[1-9]\\d{8}$', 'ETB', 'ብር', 'Africa/Addis_Ababa', 'Ethiopian Birr'],
            ['Fiji', 'FJ', 'FJI', '+679', '^\\+679[1-9]\\d{6}$', 'FJD', '$', 'Pacific/Fiji', 'Fijian Dollar'],
            ['Finland', 'FI', 'FIN', '+358', '^\\+358[1-9]\\d{8}$', 'EUR', '€', 'Europe/Helsinki', 'Euro'],
            ['France', 'FR', 'FRA', '+33', '^\\+33[1-9]\\d{8}$', 'EUR', '€', 'Europe/Paris', 'Euro'],
            ['Gabon', 'GA', 'GAB', '+241', '^\\+241[1-9]\\d{6}$', 'GAB', 'CFA', 'Africa/Libreville', 'CFA Franc'],
            ['Gambia', 'GM', 'GMB', '+220', '^\\+220[1-9]\\d{6}$', 'GMB', 'D', 'Africa/Banjul', 'Gambian Dalasi'],
            ['Georgia', 'GE', 'GEO', '+995', '^\\+995[1-9]\\d{8}$', 'GEL', '₾', 'Asia/Tbilisi', 'Georgian Lari'],
            ['Germany', 'DE', 'DEU', '+49', '^\\+49[1-9]\\d{8,10}$', 'EUR', '€', 'Europe/Berlin', 'Euro'],
            ['Ghana', 'GH', 'GHA', '+233', '^\\+233[1-9]\\d{7}$', 'GHS', '₵', 'Africa/Accra', 'Ghanaian Cedi'],
            ['Greece', 'GR', 'GRC', '+30', '^\\+30[1-9]\\d{7,9}$', 'GRD', '₯', 'Europe/Athens', 'Drachma'],
            ['Grenada', 'GD', 'GRD', '+1-473', '^\\+1-473\\d{7}$', 'XCD', '$', 'America/Grenada', 'East Caribbean Dollar'],
            ['Guatemala', 'GT', 'GTM', '+502', '^\\+502[1-9]\\d{7}$', 'GTQ', 'Q', 'America/Guatemala', 'Guatemalan Quetzal'],
            ['Guinea', 'GN', 'GIN', '+224', '^\\+224[1-9]\\d{7}$', 'GNF', 'Fr', 'Africa/Conakry', 'Guinean Franc'],
            ['Guinea-Bissau', 'GW', 'GNB', '+245', '^\\+245[1-9]\\d{6}$', 'GNF', 'Fr', 'Africa/Bissau', 'Guinean Franc'],
            ['Guyana', 'GY', 'GUY', '+592', '^\\+592[1-9]\\d{7}$', 'GYD', '$', 'America/Guyana', 'Guyanese Dollar'],
            ['Haiti', 'HT', 'HTI', '+509', '^\\+509[1-9]\\d{6}$', 'HTG', 'G', 'America/Port-au-Prince', 'Haitian Gourde'],
            ['Honduras', 'HN', 'HND', '+504', '^\\+504[1-9]\\d{7}$', 'HNL', 'L', 'America/Tegucigalpa', 'Honduran Lempira'],
            ['Hungary', 'HU', 'HUN', '+36', '^\\+36[1-9]\\d{7}$', 'HUF', 'Ft', 'Europe/Budapest', 'Hungarian Forint'],
            ['Iceland', 'IS', 'ISL', '+354', '^\\+354[1-9]\\d{7}$', 'ISK', 'kr', 'Europe/Reykjavik', 'Icelandic Krona'],
            ['India', 'IN', 'IND', '+91', '^\\+91[1-9]\\d{9}$', 'INR', '₹', 'Asia/Kolkata', 'Indian Rupee'],
            ['Indonesia', 'ID', 'IDN', '+62', '^\\+62[1-9]\\d{8,9}$', 'IDR', 'Rp', 'Asia/Jakarta', 'Indonesian Rupiah'],
            ['Italy', 'IT', 'ITA', '+39', '^\\+39[1-9]\\d{8,9}$', 'EUR', '€', 'Europe/Rome', 'Euro'],
            ['Japan', 'JP', 'JPN', '+81', '^\\+81[1-9]\\d{8}$', 'JPY', '¥', 'Asia/Tokyo', 'Japanese Yen'],
            ['Jamaica', 'JM', 'JAM', '+1-876', '^\\+1-876\\d{7}$', 'JMD', 'J$', 'America/Jamaica', 'Jamaican Dollar'],
            ['Jordan', 'JO', 'JOR', '+962', '^\\+962[1-9]\\d{7}$', 'JOD', 'د.ا', 'Asia/Amman', 'Jordanian Dinar'],
            ['Kazakhstan', 'KZ', 'KAZ', '+7', '^\\+7[1-9]\\d{9}$', 'KZT', '₸', 'Asia/Almaty', 'Kazakhstani Tenge'],
            ['Kenya', 'KE', 'KEN', '+254', '^\\+254[1-9]\\d{8}$', 'KES', 'KSh', 'Africa/Nairobi', 'Kenyan Shilling'],
            ['South Korea', 'KR', 'KOR', '+82', '^\\+82[1-9]\\d{8}$', 'KRW', '₩', 'Asia/Seoul', 'South Korean Won'],
            ['Kuwait', 'KW', 'KWT', '+965', '^\\+965[1-9]\\d{7}$', 'KWD', 'د.ك', 'Asia/Kuwait', 'Kuwaiti Dinar'],
            ['Latvia', 'LV', 'LVA', '+371', '^\\+371[1-9]\\d{7}$', 'EUR', '€', 'Europe/Riga', 'Euro'],
            ['Lebanon', 'LB', 'LBN', '+961', '^\\+961[1-9]\\d{7}$', 'LBP', 'ل.ل', 'Asia/Beirut', 'Lebanese Pound'],
            ['Malaysia', 'MY', 'MYS', '+60', '^\\+60[1-9]\\d{8}$', 'MYR', 'RM', 'Asia/Kuala_Lumpur', 'Malaysian Ringgit'],
            ['Mexico', 'MX', 'MEX', '+52', '^\\+52[1-9]\\d{9}$', 'MXN', '$', 'America/Mexico_City', 'Mexican Peso'],
            ['Netherlands', 'NL', 'NLD', '+31', '^\\+31[1-9]\\d{8}$', 'EUR', '€', 'Europe/Amsterdam', 'Euro'],
            ['New Zealand', 'NZ', 'NZL', '+64', '^\\+64[1-9]\\d{8}$', 'NZD', '$', 'Pacific/Auckland', 'New Zealand Dollar'],
            ['Nigeria', 'NG', 'NGA', '+234', '^\\+234[1-9]\\d{8}$', 'NGN', '₦', 'Africa/Lagos', 'Nigerian Naira'],
            ['Norway', 'NO', 'NOR', '+47', '^\\+47[1-9]\\d{7}$', 'NOK', 'kr', 'Europe/Oslo', 'Norwegian Krone'],
            ['Pakistan', 'PK', 'PAK', '+92', '^\\+92[1-9]\\d{9}$', 'PKR', '₨', 'Asia/Karachi', 'Pakistani Rupee'],
            ['Peru', 'PE', 'PER', '+51', '^\\+51[1-9]\\d{8}$', 'PEN', 'S/', 'America/Lima', 'Peruvian Sol'],
            ['Philippines', 'PH', 'PHL', '+63', '^\\+63[1-9]\\d{9}$', 'PHP', '₱', 'Asia/Manila', 'Philippine Peso'],
            ['Poland', 'PL', 'POL', '+48', '^\\+48[1-9]\\d{8}$', 'PLN', 'zł', 'Europe/Warsaw', 'Polish Złoty'],
            ['Portugal', 'PT', 'PRT', '+351', '^\\+351[1-9]\\d{8}$', 'EUR', '€', 'Europe/Lisbon', 'Euro'],
            ['Qatar', 'QA', 'QAT', '+974', '^\\+974[1-9]\\d{7}$', 'QAR', 'ر.ق', 'Asia/Qatar', 'Qatari Riyal'],
            ['Romania', 'RO', 'ROU', '+40', '^\\+40[1-9]\\d{8}$', 'RON', 'lei', 'Europe/Bucharest', 'Romanian Leu'],
            ['Russia', 'RU', 'RUS', '+7', '^\\+7[1-9]\\d{9}$', 'RUB', '₽', 'Europe/Moscow', 'Russian Ruble'],
            ['Saudi Arabia', 'SA', 'SAU', '+966', '^\\+966[1-9]\\d{8}$', 'SAR', 'ر.س', 'Asia/Riyadh', 'Saudi Riyal'],
            ['Singapore', 'SG', 'SGP', '+65', '^\\+65[1-9]\\d{8}$', 'SGD', '$', 'Asia/Singapore', 'Singapore Dollar'],
            ['South Africa', 'ZA', 'ZAF', '+27', '^\\+27[1-9]\\d{8}$', 'ZAR', 'R', 'Africa/Johannesburg', 'South African Rand'],
            ['Spain', 'ES', 'ESP', '+34', '^\\+34[1-9]\\d{8}$', 'EUR', '€', 'Europe/Madrid', 'Euro'],
            ['Sweden', 'SE', 'SWE', '+46', '^\\+46[1-9]\\d{8}$', 'SEK', 'kr', 'Europe/Stockholm', 'Swedish Krona'],
            ['Switzerland', 'CH', 'CHE', '+41', '^\\+41[1-9]\\d{8}$', 'CHF', 'Fr', 'Europe/Zurich', 'Swiss Franc'],
            ['Thailand', 'TH', 'THA', '+66', '^\\+66[1-9]\\d{8}$', 'THB', '฿', 'Asia/Bangkok', 'Thai Baht'],
            ['Turkey', 'TR', 'TUR', '+90', '^\\+90[1-9]\\d{9}$', 'TRY', '₺', 'Europe/Istanbul', 'Turkish Lira'],
            ['United Arab Emirates', 'AE', 'ARE', '+971', '^\\+971[1-9]\\d{8}$', 'AED', 'د.إ', 'Asia/Dubai', 'UAE Dirham'],
            ['United Kingdom', 'GB', 'GBR', '+44', '^\\+44[1-9]\\d{8,9}$', 'GBP', '£', 'Europe/London', 'British Pound'],
            ['United States', 'US', 'USA', '+1', '^\\+1[2-9]\\d{2}[2-9]\\d{2}\\d{4}$', 'USD', '$', 'America/New_York', 'United States Dollar'],
            ['Vietnam', 'VN', 'VNM', '+84', '^\\+84[1-9]\\d{8}$', 'VND', '₫', 'Asia/Ho_Chi_Minh', 'Vietnamese Dong'],
            ['Zambia', 'ZM', 'ZMB', '+260', '^\\+260[1-9]\\d{8}$', 'ZMW', 'ZK', 'Africa/Lusaka', 'Zambian Kwacha'],
            ['Zimbabwe', 'ZW', 'ZWE', '+263', '^\\+263[1-9]\\d{8}$', 'ZWL', 'Z$', 'Africa/Harare', 'Zimbabwean Dollar'],
        ];

        // Insert countries using the Country model
        foreach ($countries as $country) {
            Country::create([
                'name' => $country[0],
                'iso2_code' => $country[1],
                'iso3_code' => $country[2],
                'phone_code' => $country[3],
                'phone_regex' => $country[4],
                'currency_code' => $country[5],
                'currency_symbol' => $country[6],
                'timezone' => $country[7],
                'currency_name' => $country[8],
            ]);
        }

        $this->command->info('Countries seeded successfully from array.');
    }
}
