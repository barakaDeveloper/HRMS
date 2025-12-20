<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

/**
 * Class Employee
 *
 * @property int $id
 * @property string $employee_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property \Illuminate\Support\Carbon|null $date_of_birth
 * @property string|null $gender
 * @property string|null $national_id
 * @property string|null $marital_status
 * @property string|null $department
 * @property string|null $profession
 * @property string|null $employment_type
 * @property string|null $employee_status
 * @property string|null $work_location
 * @property \Illuminate\Support\Carbon|null $join_date
 * @property float|null $salary
 * @property string|null $salary_currency
 * @property int|null $productivity
 * @property string|null $profile_photo_url
 * @property array|null $documents
 * @property array|null $key_performance_indicators
 * @property bool $is_active
 */
class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'name',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'national_id',
        'marital_status',
        'department',
        'profession',
        'employment_type',
        'employee_status',
        'work_location',
        'join_date',
        'salary',
        'salary_currency',
        'bank_name',
        'bank_account_number',
        'bank_account_name',
        'last_salary_increment_date',
        'bonus',
        'bonus_currency',
        'commission',
        'commission_currency',
        'allowances',
        'allowances_currency',
        'emergency_contact',
        'address',
        'notes',
        'productivity',
        'key_performance_indicators',
        'documents',
        'profile_photo_url',
        'is_active'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'join_date' => 'date',
        'last_salary_increment_date' => 'date',
        'salary' => 'decimal:2',
        'bonus' => 'decimal:2',
        'commission' => 'decimal:2',
        'allowances' => 'decimal:2',
        'productivity' => 'integer',
        'key_performance_indicators' => 'array',
        'documents' => 'array',
        'is_active' => 'boolean'
    ];

    // Currency constants
    const CURRENCY_TZS = 'TZS';
    const CURRENCY_USD = 'USD';

    /**
     * Get available currencies
     *
     * @return array<string, string>
     */
    public static function getCurrencies(): array
    {
        return [
            self::CURRENCY_TZS => 'Tanzanian Shilling (TZS)',
            self::CURRENCY_USD => 'US Dollar (USD)',
        ];
    }

    /**
     * Get default currency
     *
     * @return string
     */
    public function getDefaultCurrency(): string
    {
        return self::CURRENCY_TZS;
    }

    /**
     * Get profile photo URL
     *
     * @param string|null $value
     * @return string
     */
    public function getProfilePhotoUrlAttribute($value): string
    {
        if ($value && !empty($value)) {
            // Check if it's a full URL
            if (filter_var($value, FILTER_VALIDATE_URL)) {
                return $value;
            }
            // Check if file exists in storage
            if (Storage::disk('public')->exists($value)) {
                return asset('storage/' . $value);
            }
        }
        
        // Fallback to Gravatar
        $email = $this->attributes['email'] ?? '';
        $hash = md5(strtolower(trim($email)));
        return "https://www.gravatar.com/avatar/{$hash}?s=300&d=identicon";
    }

    /**
     * Get employee age
     *
     * @return int|null
     */

public function getAgeAttribute(): ?int
{
    if (!$this->date_of_birth) {
        return null;
    }

    return Carbon::parse($this->date_of_birth)->age;
}

    /**
     * Get years of service
     *
     * @return int|null
     */
    public function getYearsOfServiceAttribute(): ?int
    {
        if (!$this->join_date) {
            return null;
        }
        return now()->diffInYears($this->join_date);
    }

    /**
     * Get formatted salary
     *
     * @return string
     */
    public function getFormattedSalaryAttribute(): string
    {
        $salary = $this->attributes['salary'] ?? null;
        if (!$salary || $salary == 0) {
            return 'Not set';
        }
        $currency = $this->attributes['salary_currency'] ?? $this->getDefaultCurrency();
        $decimals = $currency === self::CURRENCY_USD ? 2 : 0;
        $formatted = number_format((float)$salary, $decimals);
        return $formatted . ' ' . $currency;
    }

    /**
     * Get formatted bonus
     *
     * @return string
     */
    public function getFormattedBonusAttribute(): string
    {
        $bonus = $this->attributes['bonus'] ?? null;
        if (!$bonus || $bonus == 0) {
            return 'Not set';
        }
        $currency = $this->attributes['bonus_currency'] ?? $this->getDefaultCurrency();
        $decimals = $currency === self::CURRENCY_USD ? 2 : 0;
        $formatted = number_format((float)$bonus, $decimals);
        return $formatted . ' ' . $currency;
    }

    /**
     * Get formatted commission
     *
     * @return string
     */
    public function getFormattedCommissionAttribute(): string
    {
        $commission = $this->attributes['commission'] ?? null;
        if (!$commission || $commission == 0) {
            return 'Not set';
        }
        $currency = $this->attributes['commission_currency'] ?? $this->getDefaultCurrency();
        $decimals = $currency === self::CURRENCY_USD ? 2 : 0;
        $formatted = number_format((float)$commission, $decimals);
        return $formatted . ' ' . $currency;
    }

    /**
     * Get formatted allowances
     *
     * @return string
     */
    public function getFormattedAllowancesAttribute(): string
    {
        $allowances = $this->attributes['allowances'] ?? null;
        if (!$allowances || $allowances == 0) {
            return 'Not set';
        }
        $currency = $this->attributes['allowances_currency'] ?? $this->getDefaultCurrency();
        $decimals = $currency === self::CURRENCY_USD ? 2 : 0;
        $formatted = number_format((float)$allowances, $decimals);
        return $formatted . ' ' . $currency;
    }

    /**
     * Get currency symbol
     *
     * @param string|null $currency
     * @return string
     */
    public function getCurrencySymbol(?string $currency = null): string
    {
        $currency = $currency ?? $this->attributes['salary_currency'] ?? $this->getDefaultCurrency();
        return $currency === self::CURRENCY_USD ? '$' : 'TSh';
    }

    /**
     * Get salary with symbol
     *
     * @return string
     */
    public function getSalaryWithSymbolAttribute(): string
    {
        $salary = $this->attributes['salary'] ?? null;
        if (!$salary || $salary == 0) {
            return 'Not set';
        }
        $currency = $this->attributes['salary_currency'] ?? $this->getDefaultCurrency();
        $symbol = $this->getCurrencySymbol($currency);
        $decimals = $currency === self::CURRENCY_USD ? 2 : 0;
        $formatted = number_format((float)$salary, $decimals);
        return $symbol . ' ' . $formatted;
    }

    /**
     * Get bonus with symbol
     *
     * @return string
     */
    public function getBonusWithSymbolAttribute(): string
    {
        $bonus = $this->attributes['bonus'] ?? null;
        if (!$bonus || $bonus == 0) {
            return 'Not set';
        }
        $currency = $this->attributes['bonus_currency'] ?? $this->getDefaultCurrency();
        $symbol = $this->getCurrencySymbol($currency);
        $decimals = $currency === self::CURRENCY_USD ? 2 : 0;
        $formatted = number_format((float)$bonus, $decimals);
        return $symbol . ' ' . $formatted;
    }

    /**
     * Get commission with symbol
     *
     * @return string
     */
    public function getCommissionWithSymbolAttribute(): string
    {
        $commission = $this->attributes['commission'] ?? null;
        if (!$commission || $commission == 0) {
            return 'Not set';
        }
        $currency = $this->attributes['commission_currency'] ?? $this->getDefaultCurrency();
        $symbol = $this->getCurrencySymbol($currency);
        $decimals = $currency === self::CURRENCY_USD ? 2 : 0;
        $formatted = number_format((float)$commission, $decimals);
        return $symbol . ' ' . $formatted;
    }

    /**
     * Get allowances with symbol
     *
     * @return string
     */
    public function getAllowancesWithSymbolAttribute(): string
    {
        $allowances = $this->attributes['allowances'] ?? null;
        if (!$allowances || $allowances == 0) {
            return 'Not set';
        }
        $currency = $this->attributes['allowances_currency'] ?? $this->getDefaultCurrency();
        $symbol = $this->getCurrencySymbol($currency);
        $decimals = $currency === self::CURRENCY_USD ? 2 : 0;
        $formatted = number_format((float)$allowances, $decimals);
        return $symbol . ' ' . $formatted;
    }

    /**
     * Get total earnings (salary + bonus + allowances + TZS commission only)
     *
     * @return string
     */
    public function getTotalEarningsAttribute(): string
    {
        $total = 0;
        
        // Add salary in TZS
        if ($this->salary && $this->salary_currency === self::CURRENCY_TZS) {
            $total += (float)$this->salary;
        }
        
        // Add allowances in TZS
        if ($this->allowances && $this->allowances_currency === self::CURRENCY_TZS) {
            $total += (float)$this->allowances;
        }
        
        // Add bonus in TZS
        if ($this->bonus && $this->bonus_currency === self::CURRENCY_TZS) {
            $total += (float)$this->bonus;
        }
        
        // Add commission ONLY if in TZS (USD commission is separate)
        if ($this->commission && $this->commission_currency === self::CURRENCY_TZS) {
            $total += (float)$this->commission;
        }
        
        if ($total == 0) {
            return '0 TZS';
        }
        
        $formatted = number_format($total, 0);
        return $formatted . ' TZS';
    }

    /**
     * Get USD commission separately
     *
     * @return string
     */
    public function getUsdCommissionAttribute(): string
    {
        if ($this->commission && $this->commission_currency === self::CURRENCY_USD) {
            $formatted = number_format((float)$this->commission, 2);
            return '$' . $formatted;
        }
        return '$0.00';
    }

    /**
     * Get TZS commission
     *
     * @return string
     */
    public function getTzsCommissionAttribute(): string
    {
        if ($this->commission && $this->commission_currency === self::CURRENCY_TZS) {
            $formatted = number_format((float)$this->commission, 0);
            return $formatted . ' TZS';
        }
        return '0 TZS';
    }

    /**
     * Format currency helper
     *
     * @param float|null $amount
     * @param string|null $currency
     * @return string
     */
    protected function formatCurrency(?float $amount, ?string $currency): string
    {
        if (!$amount || $amount == 0) {
            return '0 ' . ($currency ?? 'TZS');
        }
        
        $currency = $currency ?? $this->getDefaultCurrency();
        $decimals = $currency === self::CURRENCY_USD ? 2 : 0;
        $formatted = number_format($amount, $decimals);
        
        if ($currency === self::CURRENCY_TZS) {
            return $formatted . ' TZS';
        } elseif ($currency === self::CURRENCY_USD) {
            return '$' . $formatted;
        }
        
        return $formatted . ' ' . $currency;
    }

    /**
     * Get formatted employee status
     *
     * @return string
     */
    public function getFormattedEmployeeStatusAttribute(): string
    {
        $status = $this->attributes['employee_status'] ?? 'active';
        if (empty($status)) {
            return 'Active';
        }
        return ucfirst(str_replace('_', ' ', $status));
    }

    /**
     * Get formatted employment type
     *
     * @return string
     */
    public function getFormattedEmploymentTypeAttribute(): string
    {
        $type = $this->attributes['employment_type'] ?? 'full_time';
        return ucfirst(str_replace('_', ' ', $type));
    }

    /**
     * Get formatted marital status
     *
     * @return string
     */
    public function getFormattedMaritalStatusAttribute(): string
    {
        $status = $this->attributes['marital_status'] ?? null;
        if (empty($status)) {
            return 'Not set';
        }
        return ucfirst($status);
    }

    /**
     * Check if employee has documents
     *
     * @return bool
     */
    public function hasDocuments(): bool
    {
        $documents = $this->attributes['documents'] ?? null;
        
        // Handle JSON string
        if (is_string($documents)) {
            $documents = json_decode($documents, true);
        }
        
        return !empty($documents) && is_array($documents) && count($documents) > 0;
    }

    /**
     * Check if employee has KPIs
     *
     * @return bool
     */
    public function hasKpis(): bool
    {
        $kpis = $this->attributes['key_performance_indicators'] ?? null;
        
        // Handle JSON string
        if (is_string($kpis)) {
            $kpis = json_decode($kpis, true);
        }
        
        return !empty($kpis) && is_array($kpis) && count($kpis) > 0;
    }

    /**
     * Get productivity level (for UI colors)
     *
     * @return string
     */
    public function getProductivityLevelAttribute(): string
    {
        $productivity = (int)($this->attributes['productivity'] ?? 0);
        
        if ($productivity >= 85) {
            return 'high';
        } elseif ($productivity >= 70) {
            return 'medium';
        } else {
            return 'low';
        }
    }

    /**
     * Get route key name for route model binding
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'id';
    }

    /**
     * Get KPIs attribute with safe handling
     *
     * @return array
     */
    public function getKeyPerformanceIndicatorsAttribute($value)
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        
        if (is_array($value)) {
            return $value;
        }
        
        return [];
    }

    /**
     * Get documents attribute with safe handling
     *
     * @return array
     */
    public function getDocumentsAttribute($value)
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        
        if (is_array($value)) {
            // Filter out invalid documents
            return array_filter($value, function($doc) {
                return is_array($doc) && isset($doc['name']);
            });
        }
        
        return [];
    }

    /**
     * Get productivity with fallback
     *
     * @return int
     */
    public function getProductivityAttribute($value)
    {
        return $value ?? 0;
    }
}