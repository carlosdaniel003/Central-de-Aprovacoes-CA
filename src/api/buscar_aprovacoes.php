<?php
// src/api/buscar_aprovacoes.php

header('Content-Type: application/json');

require_once '../config/config.php';
require_once '../services/SupabaseService.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        throw new Exception('Método não permitido. Utilize GET.');
    }

    $supabaseService = new SupabaseService();
    $data = $supabaseService->getApprovals();

    // Mapeia os dados do formato snake_case do banco para o formato esperado pelo JS
    $formattedData = array_map(function($item) {
        return [
            'id' => $item['id'],
            'model' => $item['model'],
            'symptom' => $item['symptom'],
            'detail' => $item['detail'],
            'status' => $item['status'],
            'defectSheetUrl' => $item['defect_sheet_url'],
            'defectPhotoUrl' => $item['defect_photo_url'],
            // NOVO: Puxando o campo da base de dados e mapeando para o JS
            'approvedBy' => $item['approved_by'] ?? 'Não informado',
            'createdAt' => $item['created_at']
        ];
    }, $data);

    echo json_encode([
        'success' => true,
        'data' => $formattedData
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>