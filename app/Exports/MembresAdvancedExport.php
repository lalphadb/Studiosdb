/**
 * Envoyer un email à un membre
 */
public function sendEmail(Request $request, Membre $membre)
{
    $validated = $request->validate([
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
        'template' => 'nullable|string|in:bienvenue,rappel_cours,nouvelle_ceinture,personnalise'
    ]);
    
    try {
        // Envoyer l'email
        Mail::to($membre->email)->send(new MembreMail(
            $membre,
            $validated['subject'],
            $validated['message'],
            $validated['template']
        ));
        
        // Log l'envoi
        activity()
            ->performedOn($membre)
            ->causedBy(auth()->user())
            ->withProperties([
                'subject' => $validated['subject'],
                'template' => $validated['template'] ?? 'personnalise'
            ])
            ->log('Email envoyé');
        
        return back()->with('success', 'Email envoyé avec succès!');
        
    } catch (\Exception $e) {
        Log::error('Erreur envoi email: ' . $e->getMessage());
        return back()->with('error', 'Erreur lors de l\'envoi de l\'email.');
    }
}

/**
 * Mettre à jour le statut d'un membre (pour Kanban)
 */
public function updateStatus(Request $request, Membre $membre)
{
    $validated = $request->validate([
        'status' => 'required|in:en_attente,approuve,nouveau'
    ]);
    
    $updates = [];
    
    switch ($validated['status']) {
        case 'approuve':
            $updates['approuve'] = true;
            break;
        case 'en_attente':
            $updates['approuve'] = false;
            break;
        // 'nouveau' est juste pour l'affichage, pas de mise à jour
    }
    
    if (!empty($updates)) {
        $membre->update($updates);
        
        activity()
            ->performedOn($membre)
            ->causedBy(auth()->user())
            ->withProperties(['new_status' => $validated['status']])
            ->log('Statut mis à jour via Kanban');
    }
    
    return response()->json(['success' => true]);
}

/**
 * Suppression en masse
 */
public function bulkDelete(Request $request)
{
    $ids = explode(',', $request->input('ids', ''));
    
    // Si admin d'école, vérifier que les membres appartiennent à son école
    if (auth()->user()->role === 'admin') {
        $validIds = Membre::where('ecole_id', auth()->user()->ecole_id)
            ->whereIn('id', $ids)
            ->pluck('id')
            ->toArray();
    } else {
        $validIds = $ids;
    }
    
    // Supprimer les photos
    $membres = Membre::whereIn('id', $validIds)->get();
    foreach ($membres as $membre) {
        if ($membre->photo) {
            Storage::disk('public')->delete($membre->photo);
        }
    }
    
    // Supprimer les membres
    Membre::whereIn('id', $validIds)->delete();
    
    // Log
    activity()
        ->causedBy(auth()->user())
        ->withProperties(['count' => count($validIds)])
        ->log('Suppression en masse de membres');
    
    return redirect()->route('admin.membres.index')
        ->with('success', count($validIds) . ' membre(s) supprimé(s)');
}
