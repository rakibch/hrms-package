import { Menu } from '@/App/Interfaces/menu';
import {
    CalendarDaysIcon,
    ChartBarSquareIcon,
    UsersIcon,
} from '@heroicons/vue/24/outline';
import { ref } from 'vue';

export const menus: Menu[] = [
    {
        name: 'Dashboard',
        routeName: 'dashboard',
        icon: ChartBarSquareIcon,
    },
    {
        name: 'Employee Management',
        routeName: '#',
        icon: UsersIcon,
        subMenu: [
            { name: 'Departments', routeName: 'departments.index' },
            { name: 'Designations', routeName: 'designations.index' },
            { name: 'Employee', routeName: 'employee.index' },
        ],
    },
    {
        name: 'Leave Management',
        routeName: '#',
        icon: CalendarDaysIcon,
        subMenu: [{ name: 'Policy', routeName: 'business-hours.index' }],
    },
];

export const settings: Menu[] = [
    { name: 'Branches', routeName: 'dashboard' },
    { name: 'Language', routeName: 'dashboard' },
    { name: 'Currency', routeName: 'dashboard' },
    { name: 'VAT', routeName: 'dashboard' },
    { name: 'Register', routeName: 'dashboard' },
];

export const responsiveMenus: Menu[] = [
    { name: 'Dashboard', routeName: 'dashboard', icon: ChartBarSquareIcon },
    {
        name: 'Employee Management',
        routeName: '#',
        icon: UsersIcon,
        subMenu: [
            { name: 'Departments', routeName: 'departments.index' },
            { name: 'Designations', routeName: 'designations.index' },
            { name: 'Employee', routeName: 'employee.index' },
        ],
    },
];

export const BASE_MAP_URL = 'https://nominatim.openstreetmap.org';

export const MAP_TILES = 'https://tile.openstreetmap.org/{z}/{x}/{y}.png';

export const genders = [
    { label: 'Male', value: 'male' },
    { label: 'Female', value: 'female' },
];

export const religions = [
    { label: 'Islam', value: 'islam' },
    { label: 'Christianity', value: 'christianity' },
    { label: 'Hinduism', value: 'hinduism' },
    { label: 'Buddhism', value: 'buddhism' },
    { label: 'Judaism', value: 'judaism' },
    { label: 'Sikhism', value: 'sikhism' },
    { label: 'Other', value: 'other' },
];

export const bloodGroups = [
    { label: 'A+', value: 'A+' },
    { label: 'A-', value: 'A-' },
    { label: 'B+', value: 'B+' },
    { label: 'B-', value: 'B-' },
    { label: 'AB+', value: 'AB+' },
    { label: 'AB-', value: 'AB-' },
    { label: 'O+', value: 'O+' },
    { label: 'O-', value: 'O-' },
];

export const maritalStatus = [
    { label: 'Married', value: 'married' },
    { label: 'Single', value: 'single' },
];

export const identityTypes = [
    { label: 'Automatic', value: 'automatic' },
    { label: 'Manual', value: 'manual' },
];

export const uploadType = [
    { label: 'Upload Files', value: 'file' },
    { label: 'Links', value: 'link' },
];

export const jobNatures = [
    { label: 'On Site', value: 'onsite' },
    { label: 'Remote', value: 'remote' },
    { label: 'Hybrid', value: 'hybrid' },
];

export const employmentTypes = [
    { label: 'Intern', value: 'intern' },
    { label: 'Probation', value: 'probation' },
    { label: 'Permanent', value: 'permanent' },
    // { label: 'Part-Time', value: 'partTime' },
    { label: 'Contractual', value: 'contractual' },
    { label: 'Temporary', value: 'temporary' },
];

export const countries = [
    { label: 'Afghanistan', value: 1 },
    { label: 'Albania', value: 2 },
    { label: 'Algeria', value: 3 },
    { label: 'Andorra', value: 4 },
    { label: 'Angola', value: 5 },
    { label: 'Antigua and Barbuda', value: 6 },
    { label: 'Argentina', value: 7 },
    { label: 'Armenia', value: 8 },
    { label: 'Australia', value: 9 },
    { label: 'Austria', value: 10 },
    { label: 'Azerbaijan', value: 11 },
    { label: 'Bahamas', value: 12 },
    { label: 'Bahrain', value: 13 },
    { label: 'Bangladesh', value: 14 },
    { label: 'Barbados', value: 15 },
    { label: 'Belarus', value: 16 },
    { label: 'Belgium', value: 17 },
    { label: 'Belize', value: 18 },
    { label: 'Benin', value: 19 },
    { label: 'Bhutan', value: 20 },
    { label: 'Bolivia', value: 21 },
    { label: 'Bosnia and Herzegovina', value: 22 },
    { label: 'Botswana', value: 23 },
    { label: 'Brazil', value: 24 },
    { label: 'Brunei', value: 25 },
    { label: 'Bulgaria', value: 26 },
    { label: 'Burkina Faso', value: 27 },
    { label: 'Burundi', value: 28 },
    { label: 'Cabo Verde', value: 29 },
    { label: 'Cambodia', value: 30 },
    { label: 'Cameroon', value: 31 },
    { label: 'Canada', value: 32 },
    { label: 'Central African Republic', value: 33 },
    { label: 'Chad', value: 34 },
    { label: 'Chile', value: 35 },
    { label: 'China', value: 36 },
    { label: 'Colombia', value: 37 },
    { label: 'Comoros', value: 38 },
    { label: 'Congo, Democratic Republic of the', value: 39 },
    { label: 'Congo, Republic of the', value: 40 },
    { label: 'Costa Rica', value: 41 },
    { label: 'Croatia', value: 42 },
    { label: 'Cuba', value: 43 },
    { label: 'Cyprus', value: 44 },
    { label: 'Czech Republic', value: 45 },
    { label: 'Denmark', value: 46 },
    { label: 'Djibouti', value: 47 },
    { label: 'Dominica', value: 48 },
    { label: 'Dominican Republic', value: 49 },
    { label: 'Ecuador', value: 50 },
    { label: 'Egypt', value: 51 },
    { label: 'El Salvador', value: 52 },
    { label: 'Equatorial Guinea', value: 53 },
    { label: 'Eritrea', value: 54 },
    { label: 'Estonia', value: 55 },
    { label: 'Eswatini', value: 56 },
    { label: 'Ethiopia', value: 57 },
    { label: 'Fiji', value: 58 },
    { label: 'Finland', value: 59 },
    { label: 'France', value: 60 },
    { label: 'Gabon', value: 61 },
    { label: 'Gambia', value: 62 },
    { label: 'Georgia', value: 63 },
    { label: 'Germany', value: 64 },
    { label: 'Ghana', value: 65 },
    { label: 'Greece', value: 66 },
    { label: 'Grenada', value: 67 },
    { label: 'Guatemala', value: 68 },
    { label: 'Guinea', value: 69 },
    { label: 'Guinea-Bissau', value: 70 },
    { label: 'Guyana', value: 71 },
    { label: 'Haiti', value: 72 },
    { label: 'Honduras', value: 73 },
    { label: 'Hungary', value: 74 },
    { label: 'Iceland', value: 75 },
    { label: 'India', value: 76 },
    { label: 'Indonesia', value: 77 },
    { label: 'Iran', value: 78 },
    { label: 'Iraq', value: 79 },
    { label: 'Ireland', value: 80 },
    { label: 'Israel', value: 81 },
    { label: 'Italy', value: 82 },
    { label: 'Jamaica', value: 83 },
    { label: 'Japan', value: 84 },
    { label: 'Jordan', value: 85 },
    { label: 'Kazakhstan', value: 86 },
    { label: 'Kenya', value: 87 },
    { label: 'Kiribati', value: 88 },
    { label: 'Korea, North', value: 89 },
    { label: 'Korea, South', value: 90 },
    { label: 'Kosovo', value: 91 },
    { label: 'Kuwait', value: 92 },
    { label: 'Kyrgyzstan', value: 93 },
    { label: 'Laos', value: 94 },
    { label: 'Latvia', value: 95 },
    { label: 'Lebanon', value: 96 },
    { label: 'Lesotho', value: 97 },
    { label: 'Liberia', value: 98 },
    { label: 'Libya', value: 99 },
    { label: 'Liechtenstein', value: 100 },
    { label: 'Lithuania', value: 101 },
    { label: 'Luxembourg', value: 102 },
    { label: 'Madagascar', value: 103 },
    { label: 'Malawi', value: 104 },
    { label: 'Malaysia', value: 105 },
    { label: 'Maldives', value: 106 },
    { label: 'Mali', value: 107 },
    { label: 'Malta', value: 108 },
    { label: 'Marshall Islands', value: 109 },
    { label: 'Mauritania', value: 110 },
    { label: 'Mauritius', value: 111 },
    { label: 'Mexico', value: 112 },
    { label: 'Micronesia', value: 113 },
    { label: 'Moldova', value: 114 },
    { label: 'Monaco', value: 115 },
    { label: 'Mongolia', value: 116 },
    { label: 'Montenegro', value: 117 },
    { label: 'Morocco', value: 118 },
    { label: 'Mozambique', value: 119 },
    { label: 'Myanmar (Burma)', value: 120 },
    { label: 'Namibia', value: 121 },
    { label: 'Nauru', value: 122 },
    { label: 'Nepal', value: 123 },
    { label: 'Netherlands', value: 124 },
    { label: 'New Zealand', value: 125 },
    { label: 'Nicaragua', value: 126 },
    { label: 'Niger', value: 127 },
    { label: 'Nigeria', value: 128 },
    { label: 'North Macedonia', value: 129 },
    { label: 'Norway', value: 130 },
    { label: 'Oman', value: 131 },
    { label: 'Pakistan', value: 132 },
    { label: 'Palau', value: 133 },
    { label: 'Palestine', value: 134 },
    { label: 'Panama', value: 135 },
    { label: 'Papua New Guinea', value: 136 },
    { label: 'Paraguay', value: 137 },
    { label: 'Peru', value: 138 },
    { label: 'Philippines', value: 139 },
    { label: 'Poland', value: 140 },
    { label: 'Portugal', value: 141 },
    { label: 'Qatar', value: 142 },
    { label: 'Romania', value: 143 },
    { label: 'Russia', value: 144 },
    { label: 'Rwanda', value: 145 },
    { label: 'Saint Kitts and Nevis', value: 146 },
    { label: 'Saint Lucia', value: 147 },
    { label: 'Saint Vincent and the Grenadines', value: 148 },
    { label: 'Samoa', value: 149 },
];

export const relations = [
    { label: 'Father', value: 'father' },
    { label: 'Mother', value: 'mother' },
    { label: 'Brother', value: 'brother' },
    { label: 'Sister', value: 'sister' },
    { label: 'Spouse', value: 'spouse' },
    { label: 'Child', value: 'child' },
    { label: 'Friend', value: 'friend' },
    { label: 'Colleague', value: 'colleague' },
    { label: 'Other', value: 'other' },
];

export const jobStatus = [
    { label: 'Active', value: 'active' },
    { label: 'Inactive', value: 'inactive' },
    { label: 'Terminated', value: 'terminated' },
    { label: 'Resigned', value: 'resigned' },
];

export const profileStatus = [
    { label: 'Draft', value: 'draft' },
    { label: 'Complete', value: 'complete' },
];

export const employmentEvent = [
    { label: 'Active', value: 'active' },
    { label: 'Inactive', value: 'inactive' },
    { label: 'Terminated', value: 'terminated' },
    { label: 'Resigned', value: 'resigned' },
    { label: 'Go Abroad', value: 'goabroad' },
    { label: 'Deceased', value: 'deceased' },
];

export const degrees = [
    'Bachelor of Science (B.Sc.)',
    'Master of Science (M.Sc.)',
    'Doctor of Philosophy (Ph.D.)',
    'Bachelor of Technology (B.Tech.)',
    'Master of Technology (M.Tech.)',
    'Bachelor of Computer Science (B.CompSc.)',
    'Master of Computer Applications (MCA)',
    'Bachelor of Information Technology (B.IT)',
    'Master of Information Technology (M.IT)',
    'Bachelor of Engineering (B.E.)',
    'Master of Engineering (M.E.)',
    'Bachelor of Civil Engineering (BCE)',
    'Bachelor of Electrical Engineering (BEE)',
    'Bachelor of Mechanical Engineering (BME)',
    'Bachelor of Software Engineering (BSE)',
    'Bachelor of Electronics and Communication Engineering (BECE)',
];

export const genderOptions = [
    { value: 'all', label: 'All' },
    { value: 'male', label: 'Male' },
    { value: 'female', label: 'Female' },
];

export const monthOptions = [
    { value: 1, label: '1 Month' },
    { value: 2, label: '2 Month' },
    { value: 3, label: '3 Month' },
    { value: 4, label: '4 Month' },
    { value: 5, label: '5 Month' },
    { value: 6, label: '6 Month' },
    { value: 7, label: '7 Month' },
    { value: 8, label: '8 Month' },
    { value: 9, label: '9 Month' },
    { value: 10, label: '10 Month' },
    { value: 11, label: '11 Month' },
    { value: 12, label: '12 Month' },
];

export const encashmentTypeOptions = [
    { value: 'gross', label: 'Gross' },
    { value: 'basic', label: 'Basic' },
];

export const employeeTypes = [
    { value: 'permanent', label: 'Permanent' },
    { value: 'contractual', label: 'Contractual' },
    { value: 'part-time', label: 'Part Time' },
    { value: 'probation', label: 'Probation' },
    { value: 'temporary', label: 'Temporary' },
    { value: 'intern', label: 'Intern' },
];

export const policyYearOptions = [
    { value: 2025, label: '2025' },
    { value: 2026, label: '2026' },
    { value: 2027, label: '2027' },
    { value: 2028, label: '2028' },
    { value: 2029, label: '2029' },
    { value: 2030, label: '2030' },
];

export const conditionTypes = [
    { value: 'none', label: 'None' },
    { value: 'encashment', label: 'Encashment' },
    { value: 'carry-forward', label: 'Carry Forward' },
];

export const holidayTypes = [
    { value: 'government', label: 'Government' },
    { value: 'private', label: 'Private' },
    { value: 'softzino', label: 'Softzino' },
];


