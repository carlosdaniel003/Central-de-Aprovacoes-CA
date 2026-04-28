<?php
// src/api/salvar_aprovacao.php

// 1. Configura o cabeçalho para responder em JSON
header('Content-Type: application/json');

// 2. Importa dependências
require_once '../config/config.php';
require_once '../services/SupabaseService.php';

try {
    // Verifica se a requisição é do tipo POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método não permitido. Utilize POST.');
    }

    // Coleta os textos enviados pelo JavaScript
    $model = $_POST['model'] ?? null;
    $symptom = $_POST['symptom'] ?? null;
    $detail = $_POST['detail'] ?? '';
    // NOVO: Coletando o campo Aprovado Por
    $approvedBy = $_POST['approvedBy'] ?? 'Não informado'; 
    $status = 'Aprovado'; // Regra de negócio fixa definida no projeto

    // Validação Básica de Segurança (Adicionado o approvedBy)
    if (!$model || !$symptom || !$approvedBy) {
        throw new Exception('Modelo, Sintoma e Aprovador são obrigatórios.');
    }

    // Verifica se as imagens foram enviadas corretamente
    if (!isset($_FILES['defectSheetImage']) || $_FILES['defectSheetImage']['error'] !== UPLOAD_ERR_OK ||
        !isset($_FILES['defectPhotoImage']) || $_FILES['defectPhotoImage']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('A Ficha e a Foto do defeito são obrigatórias.');
    }

    // Instancia o nosso serviço customizado do Supabase
    $supabaseService = new SupabaseService();

    // 3. Faz o Upload das Imagens (Storage)
    $sheetUrl = $supabaseService->uploadImage(
        $_FILES['defectSheetImage']['tmp_name'],
        $_FILES['defectSheetImage']['name'],
        $_FILES['defectSheetImage']['type'],
        'sheets' // Pasta lógica
    );

    $photoUrl = $supabaseService->uploadImage(
        $_FILES['defectPhotoImage']['tmp_name'],
        $_FILES['defectPhotoImage']['name'],
        $_FILES['defectPhotoImage']['type'],
        'photos' // Pasta lógica
    );

    // 4. Prepara o pacote de dados para o Banco
    $dbPayload = [
        'model' => $model,
        'symptom' => $symptom,
        'detail' => $detail,
        'status' => $status,
        'defect_sheet_url' => $sheetUrl,
        'defect_photo_url' => $photoUrl,
        // NOVO: Salvando na coluna 'approved_by' do Supabase
        'approved_by' => $approvedBy 
    ];

    // 5. Salva no Banco de Dados
    $insertedData = $supabaseService->insertApproval($dbPayload);

    // 6. Retorna sucesso para o JavaScript
    echo json_encode([
        'success' => true,
        'data' => $insertedData
    ]);

} catch (Exception $e) {
    // Em caso de qualquer erro, retorna um JSON de erro seguro
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>