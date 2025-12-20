<?php
// app/Models/Department.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $description
 * @property string|null $team_function
 * @property int|null $employee_count
 * @property string|null $color_scheme
 * @property string|null $initial
 * @property bool $is_active
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read int $professions_count
 * @property-read float $progress_percentage
 * @property-read string $initial_letter
 * @property-read string $progress_bar_color
 */
class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'description',
        'team_function',
        'employee_count',
        'color_scheme',
        'initial',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'employee_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    protected $appends = [
        'professions_count',
        'progress_percentage',
        'initial_letter',
        'progress_bar_color'
    ];

    /**
     * Get the professions for this department
     */
    public function professions(): HasMany
    {
        return $this->hasMany(DepartmentProfession::class);
    }

    /**
     * Scope a query to only include active departments.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include inactive departments.
     */
    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    /**
     * Scope a query to search departments.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
    }

    /**
     * Get the professions count attribute.
     */
    public function getProfessionsCountAttribute(): int
    {
        if ($this->relationLoaded('professions')) {
            return $this->professions->count();
        }
        
        return $this->professions()->count();
    }

    /**
     * Get the progress percentage attribute for UI display.
     * Based on employee count (max 40 for visualization)
     */
    public function getProgressPercentageAttribute(): float
    {
        $maxTeamSize = 40;
        return min(100, ($this->employee_count / $maxTeamSize) * 100);
    }

    /**
     * Get the color class for the progress bar based on color scheme.
     */
    public function getProgressBarColorAttribute(): string
    {
        $colorMap = [
            'from-blue-500 to-purple-600' => 'bg-blue-500',
            'from-green-500 to-teal-600' => 'bg-green-500',
            'from-orange-500 to-red-600' => 'bg-orange-500',
            'from-purple-500 to-pink-600' => 'bg-purple-500',
            'from-emerald-500 to-cyan-600' => 'bg-emerald-500',
            'from-yellow-500 to-cyan-600' => 'bg-yellow-500',
            'from-gray-500 to-gray-600' => 'bg-gray-500',
        ];

        return $colorMap[$this->color_scheme] ?? 'bg-gray-500';
    }

    /**
     * Get the initial letter for the department badge.
     */
    public function getInitialLetterAttribute(): string
    {
        return $this->initial ?: strtoupper(substr($this->name, 0, 2));
    }

    /**
     * Calculate average team size across all departments.
     */
    public static function getAverageTeamSize(): float
    {
        return (float) self::active()->avg('employee_count') ?? 0;
    }

    /**
     * Get total employees across all departments.
     */
    public static function getTotalEmployees(): int
    {
        return (int) self::active()->sum('employee_count');
    }

    /**
     * Get total active departments count.
     */
    public static function getActiveDepartmentsCount(): int
    {
        return self::active()->count();
    }

    /**
     * Add employees to the department.
     */
    public function addEmployees(int $count = 1): self
    {
        $this->increment('employee_count', $count);
        return $this;
    }

    /**
     * Remove employees from the department.
     */
    public function removeEmployees(int $count = 1): self
    {
        $newCount = max(0, $this->employee_count - $count);
        $this->update(['employee_count' => $newCount]);
        return $this;
    }

    /**
     * Check if department has employees.
     */
    public function hasEmployees(): bool
    {
        return $this->employee_count > 0;
    }

    /**
     * Activate the department.
     */
    public function activate(): self
    {
        $this->update(['is_active' => true]);
        return $this;
    }

    /**
     * Deactivate the department.
     */
    public function deactivate(): self
    {
        $this->update(['is_active' => false]);
        return $this;
    }

    /**
     * Toggle department active status.
     */
    public function toggleStatus(): self
    {
        $this->update(['is_active' => !$this->is_active]);
        return $this;
    }

    /**
     * Check if department can be deleted (no employees).
     */
    public function canBeDeleted(): bool
    {
        return $this->employee_count === 0;
    }

    /**
     * Get color scheme classes for gradient background.
     */
    public function getGradientClasses(): string
    {
        return $this->color_scheme ?: 'from-gray-500 to-gray-600';
    }
}