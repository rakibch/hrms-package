export interface Employee {
    id: number;
    name: string;
    department_name: string;
    designation_name: string;
    join_date: string;
    status: string;
    profile_status: string;
    created_by: string;
}

export interface Supervisor {
    label: string;
    value: number;
}

export interface Address {
    label?: string;
    type?: 'present' | 'permanent';
    country: string;
    city: string;
    streetAddress: string;
    stateOrProvince: string;
    postcode: string;
}

export interface Document {
    id?: number;
    type: string;
    files?: Array<string | File>;
    expiry_date?: string;
    _delete?: boolean;
}

export interface EducationalInformation {
    id?: number;
    employee_id?: number;
    institution_name: string;
    degree: string;
    field_of_study: string;
    start_date?: string | null;
    end_date?: string | null;
    grade?: number | null;
    certificate_file_path?: string | null;
    is_running: boolean;
    created_by?: number;
    updated_by?: number | null;
    created_at?: string;
    updated_at?: string;
    deleted_at?: string | null;
    _delete?: boolean;
}

export interface ProfessionalExperience {
    id?: number;
    employee_id?: number;
    institution_name: string;
    designation: string;
    start_date?: string;
    end_date?: string;
    is_running: boolean;
    created_by?: number;
    updated_by?: number;
    created_at?: string;
    updated_at?: string;
    deleted_at?: string;
    _delete?: boolean;
}

export interface Experience {
    institutionName: string;
    designation: string;
    from: string;
    isRunning: boolean;
    to?: string;
}

export interface Certification {
    id?: number;
    employee_id?: number;
    course_name: string;
    issuing_organization: string;
    start_date: string;
    completion_date: string | null;
    completion_files: File[] | null;
    certificate_urls: string | null;
    created_by?: number;
    updated_by?: number | null;
    created_at?: string;
    updated_at?: string;
    deleted_at?: string | null;
    _delete?: boolean;
}

export interface Achievements {
    education: EducationalInformation[];
    work_experience: ProfessionalExperience[];
    certifications: Certification[];
}

export interface Location {
    isSameAsPresentAddress: boolean;
    country: string;
    city: string;
    streetAddress: string;
    stateOrProvince: string;
    postcode: string;
    lat: string;
    long: string;
}

export interface PersonalFormData {
    profileImage: File | string | null;
    firstName: string;
    lastName: string;
    dateOfBirth: string;
    gender: 'male' | 'female';
    maritalStatus: 'married' | 'single';
    spouseName?: string;
    religion: string;
    bloodGroup: string;
}

export interface OfficialInfo {
    job_type: string;
    department_id: number | null;
    designation_id: number | null;
    employment_type: string;
    official_contact_no: string;
    official_email: string;
}

export interface AddressInfo {
    same_as_present?: boolean;
    country?: string;
    city?: string;
    street?: string;
    state?: string;
    postal_code?: string;
    lat?: string;
    long?: string;
    coordinates?: string;
}

export interface EmergencyContact {
    name: string;
    relation: string;
    phone: string;
    address: AddressInfo;
}

export interface ContactFormData {
    id: number;
    relationship: string;
    name: string;
    contact_no: string;
    country: string;
    city: string;
    street: string;
    state: string;
    postal_code: string;
}

export interface BasicInfoForm {
    identity_type: 'manual' | 'automatic' | string;
    employee_no: string;
    user_name: string;
    join_date: string;

    profile_image: File | null;
    first_name: string;
    last_name: string;
    dob: string;
    gender: string;
    marital_status: string;
    religion: string;
    blood_group: string;

    personal_contact_no: string;
    personal_email: string;

    present_address: AddressInfo;
    permanent_address_same_as_present_address: boolean;
    permanent_address: AddressInfo;

    emergency_contacts: EmergencyContact[];

    documents: Document[];
}
