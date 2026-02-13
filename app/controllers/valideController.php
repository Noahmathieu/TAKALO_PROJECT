<?php

class ValideController {
    // ...existing code...
    public static function postValide() {
        $req = Flight::request();
        $input = [
            'email' => $req->data->email,
            'password' => $req->data->password,
        ];
        $errors = [];
        $values = $input;
        // Validation basique
        if (empty($input['email'])) {
            $errors['email'] = "L'email est requis.";
        }
        if (empty($input['password'])) {
            $errors['password'] = "Le mot de passe est requis.";
        }
        // Validation (remplace l'insertion user)
        if (empty($errors)) {
            // Ici, on effectue la validation (pas d'insertion)
            // Redirection vers message.php avec le résultat
            Flight::render('auth/message', [
                'values' => $values,
                'success' => true
            ]);
            return;
        }
        // Rendu du formulaire avec erreurs
        Flight::render('valide/valide', [
            'values' => $values,
            'errors' => $errors,
            'success' => false
        ]);
    }
}


?>