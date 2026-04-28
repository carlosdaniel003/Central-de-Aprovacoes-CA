<?php
// src/services/SupabaseService.php

class SupabaseService {
    private $url;
    private $key;

    public function __construct() {
        $this->url = SUPABASE_URL;
        $this->key = SUPABASE_KEY;
    }

    /**
     * Faz o upload de um arquivo físico para o Supabase Storage.
     * Retorna a URL pública da imagem.
     */
    public function uploadImage($fileTmpPath, $fileName, $mimeType, $folder) {
        // Limpa o nome do arquivo para evitar espaços ou caracteres especiais que quebram a URL
        $cleanFileName = preg_replace('/[^A-Za-z0-9\-\.]/', '_', $fileName);
        $uniqueName = $folder . '/' . time() . '_' . bin2hex(random_bytes(3)) . '_' . $cleanFileName;
        
        // ATENÇÃO: Verifique se o seu bucket no Supabase realmente se chama "approvals_images"
        // Se for outro nome (ex: "approvals"), mude aqui embaixo:
        $endpoint = $this->url . "/storage/v1/object/approvals_images/" . $uniqueName;
        $fileContent = file_get_contents($fileTmpPath);

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fileContent);
        // DESLIGA A VERIFICAÇÃO SSL NO WINDOWS LOCAL PARA NÃO BLOQUEAR A REQUISIÇÃO
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "apikey: " . $this->key,
            "Authorization: Bearer " . $this->key,
            "Content-Type: " . $mimeType
        ]);

        $response = curl_exec($ch);
        $curlError = curl_error($ch); // Pega o erro nativo do cURL
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Se o cURL falhar antes de chegar no Supabase (ex: erro de rede)
        if ($response === false) {
            throw new Exception("Erro de conexão cURL (Upload): " . $curlError);
        }

        // Se o Supabase rejeitar (ex: Bucket não existe, sem permissão)
        if ($httpCode !== 200) {
            throw new Exception("Supabase rejeitou o upload (Código $httpCode): " . $response);
        }

        return $this->url . "/storage/v1/object/public/approvals_images/" . $uniqueName;
    }

    /**
     * Insere um novo registro na tabela 'approvals' do banco de dados.
     */
    public function insertApproval($data) {
        $endpoint = $this->url . "/rest/v1/approvals";
        
        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        // DESLIGA A VERIFICAÇÃO SSL NO WINDOWS LOCAL
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "apikey: " . $this->key,
            "Authorization: Bearer " . $this->key,
            "Content-Type: application/json",
            "Prefer: return=representation" 
        ]);

        $response = curl_exec($ch);
        $curlError = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($response === false) {
            throw new Exception("Erro de conexão cURL (Insert): " . $curlError);
        }

        if ($httpCode !== 201 && $httpCode !== 200) {
            throw new Exception("Supabase rejeitou o insert (Código $httpCode): " . $response);
        }

        return json_decode($response, true);
    }

    /**
     * Busca todas as aprovações no banco de dados.
     */
    public function getApprovals() {
        $endpoint = $this->url . "/rest/v1/approvals?select=*&order=created_at.desc";
        
        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // DESLIGA A VERIFICAÇÃO SSL NO WINDOWS LOCAL
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "apikey: " . $this->key,
            "Authorization: Bearer " . $this->key
        ]);

        $response = curl_exec($ch);
        $curlError = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($response === false) {
            throw new Exception("Erro de conexão cURL (Select): " . $curlError);
        }

        if ($httpCode !== 200) {
            throw new Exception("Supabase rejeitou a busca (Código $httpCode): " . $response);
        }

        return json_decode($response, true);
    }
}
?>