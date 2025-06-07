<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ceinture extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'ordre',
        'couleur',
        'niveau',
    ];

    protected $casts = [
        'niveau' => 'integer',
        'ordre' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation avec les membres qui ont obtenu cette ceinture
     */
    public function membres(): BelongsToMany
    {
        return $this->belongsToMany(Membre::class, 'ceintures_obtenues')
            ->withPivot('date_obtention')
            ->withTimestamps();
    }

    /**
     * Scope pour trier par niveau
     */
    public function scopeParNiveau($query)
    {
        return $query->orderBy('niveau');
    }

    /**
     * Scope pour trier par ordre
     */
    public function scopeParOrdre($query)
    {
        return $query->orderBy('ordre');
    }

    /**
     * Obtenir la couleur en format CSS
     */
    public function getCouleurCssAttribute(): string
    {
        $couleurs = [
            'Blanc' => '#FFFFFF',
            'Jaune' => '#FFD700',
            'Orange' => '#FFA500',
            'Violet' => '#8A2BE2',
            'Bleu' => '#0000FF',
            'Vert' => '#008000',
            'Brun' => '#8B4513',
            'Noir' => '#000000',
        ];

        return $couleurs[$this->couleur] ?? '#6c757d';
    }

    /**
     * Vérifier si c'est une ceinture Dan (noire)
     */
    public function getEstDanAttribute(): bool
    {
        return $this->couleur === 'Noir';
    }
}
