import { BaseEntity } from '@/App/Interfaces/common';

export interface Department {
    id: number;
    name: string;
    total_designations: number;
    total_employees: number;
    last_modified_at: string;
    department_head: BaseEntity | null;
    created_by: string;
    status: string;
}
