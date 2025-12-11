<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepartmentProfession extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'department_id',
        'name',
        'description'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    protected $table = 'department_professions';

    protected $appends = [
        'department_name',
        'department_code'
    ];

    /**
     * Get the department that owns the profession.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Scope a query to search professions.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
    }

    /**
     * Get the department name through the relationship.
     */
    public function getDepartmentNameAttribute(): string
    {
        if ($this->relationLoaded('department') && $this->department) {
            return $this->department->name;
        }
        
        return $this->department()->value('name') ?: 'N/A';
    }

    /**
     * Get the department code through the relationship.
     */
    public function getDepartmentCodeAttribute(): string
    {
        if ($this->relationLoaded('department') && $this->department) {
            return $this->department->code;
        }
        
        return $this->department()->value('code') ?: 'N/A';
    }

    /**
     * Check if profession belongs to a specific department.
     */
    public function belongsToDepartment(int $departmentId): bool
    {
        return $this->department_id === $departmentId;
    }

    /**
     * Scope a query to only include professions for a specific department.
     */
    public function scopeForDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    /**
     * Scope a query to order by name.
     */
    public function scopeOrderByName($query, $direction = 'asc')
    {
        return $query->orderBy('name', $direction);
    }
}