import { BaseEntity } from '@/App/Interfaces/common';

export interface Designation {
    id: number;
    name: string;
    department: BaseEntity;
    total_employees: number;
    last_modified_at: string;
    supervisor: BaseEntity;
    status: 'Active' | 'Inactive';
}
