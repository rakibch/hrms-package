export interface LeavePolicy{
    policy_year: number;
    leave_type_id: number;
    name: string;
    description: string | null;
    enable_half_day: boolean;
    condition_type: 'none' | 'encashment' | 'carry-forward';
    carry_forward_limit: number | null;
    encashment_limit: number | null;
    carry_forward_month: number | null;
    encashment_type: string | null;
    gender: 'all' | 'female' | 'male';
    marital_status: 'married' | 'single';
    employee_types: { employee_type_name: string }[];
    departments: { department_id: number; department_name: string }[];
    designations: { designation_id: number; designation_name: string }[];
}
