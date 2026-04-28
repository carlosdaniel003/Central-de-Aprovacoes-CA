<?php
require_once 'src/views/header.php';
?>

<div class="ca-container">
    
    <header class="ca-header-sys">
        <div style="display: flex; align-items: center; gap: 10px;">
            <h1>
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--qc-green-forest); margin-right: 4px;">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="12" y1="18" x2="12" y2="12"></line>
                    <line x1="9" y1="15" x2="15" y2="15"></line>
                </svg>
                Nova Aprovação
            </h1>
            <span style="font-size: 12px; color: var(--qc-green-sage); font-weight: bold; text-transform: uppercase; margin-top: 6px;">[ Registro Direto ]</span>
        </div>
        <a href="index.php" class="btn btn-secondary">Voltar ao Início</a>
    </header>

    <div id="successMessage" style="display: none; background: #dcfce7; border: 1px solid #22c55e; color: #15803d; padding: 15px; border-radius: 6px; font-weight: bold; text-align: center; margin-bottom: 20px;">
        [+] APROVAÇÃO REGISTRADA COM SUCESSO!
    </div>
    <div id="errorMessage" class="alert-error text-center" style="display: none;"></div>

    <form id="approvalForm">
        
        <div class="section-divider"><span>Dados Principais</span></div>
        
        <div class="form-grid">
            <div class="form-group" style="position: relative;">
                <label class="form-label">Modelo do Produto:</label>
                <input type="text" id="modelInput" placeholder="CARREGANDO MODELOS DA BASE..." disabled class="form-control" autocomplete="off" />
                <input type="hidden" id="modelHidden" name="model" required />
                <ul id="modelDropdown" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: #fff; border: 2px solid var(--qc-green-sage); border-top: none; max-height: 250px; overflow-y: auto; z-index: 9999; margin: 0; padding: 0; list-style: none; border-radius: 0 0 8px 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.15);"></ul>
            </div>

            <div class="form-group" style="position: relative;">
                <label class="form-label">Sintoma Apresentado:</label>
                <input type="text" id="symptomInput" placeholder="DIGITE O CÓDIGO (EX: A1) OU DESCRIÇÃO..." class="form-control" autocomplete="off" />
                <input type="hidden" id="symptomHidden" name="symptom" required />
                <ul id="symptomDropdown" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: #fff; border: 2px solid var(--qc-green-sage); border-top: none; max-height: 250px; overflow-y: auto; z-index: 9999; margin: 0; padding: 0; list-style: none; border-radius: 0 0 8px 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.15);"></ul>
            </div>
        </div>

        <div class="form-group mt-4">
            <label class="form-label">Aprovado por:</label>
            <input type="text" id="approvedByInput" name="approvedBy" maxlength="100" placeholder="NOME DO RESPONSÁVEL PELA APROVAÇÃO..." class="form-control" autocomplete="off" required />
        </div>

        <div class="form-group mt-4">
            <label class="form-label">Detalhes (Descrição Opcional / Regras):</label>
            <textarea id="detailInput" name="detail" rows="4" placeholder="DESCREVA OS DETALHES EXTRAS DA APROVAÇÃO..." class="form-control" style="resize: vertical;" required minlength="10"></textarea>
        </div>

        <div class="section-divider"><span>Documentação Fotográfica</span></div>

        <div class="form-grid">
            
            <div class="form-group">
                <label class="form-label">Ficha de Aprovação:</label>
                <div style="border: 2px dashed var(--qc-border); border-radius: 8px; height: 200px; display: flex; flex-direction: column; align-items: center; justify-content: center; background: var(--qc-ice); position: relative; overflow: hidden; cursor: pointer;">
                    <img id="sheetPreview" src="" style="display: none; position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0.4; filter: grayscale(100%);" />
                    
                    <div style="position: relative; z-index: 10; background: rgba(255,255,255,0.9); padding: 8px 16px; border: 1px solid var(--qc-green-sage); border-radius: 4px; pointer-events: none; display: flex; align-items: center; gap: 8px; font-weight: bold; color: var(--qc-green-forest); font-size: 12px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" id="sheetIcon">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="12" y1="18" x2="12" y2="12"></line>
                            <line x1="9" y1="15" x2="15" y2="15"></line>
                        </svg>
                        <span id="sheetText">ANEXAR FICHA</span>
                    </div>

                    <input type="file" id="sheetFileInput" name="defectSheetImage" accept="image/*" style="position: absolute; inset: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 20;" required />
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Foto do Defeito:</label>
                <div style="border: 2px dashed var(--qc-border); border-radius: 8px; height: 200px; display: flex; flex-direction: column; align-items: center; justify-content: center; background: var(--qc-ice); position: relative; overflow: hidden; cursor: pointer;">
                    <img id="photoPreview" src="" style="display: none; position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0.4; filter: grayscale(100%);" />
                    
                    <div style="position: relative; z-index: 10; background: rgba(255,255,255,0.9); padding: 8px 16px; border: 1px solid var(--qc-green-sage); border-radius: 4px; pointer-events: none; display: flex; align-items: center; gap: 8px; font-weight: bold; color: var(--qc-green-forest); font-size: 12px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" id="photoIcon">
                            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                            <circle cx="12" cy="13" r="4"></circle>
                        </svg>
                        <span id="photoText">ANEXAR FOTO</span>
                    </div>

                    <input type="file" id="photoFileInput" name="defectPhotoImage" accept="image/*" style="position: absolute; inset: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 20;" required />
                </div>
            </div>

        </div>

        <div class="mt-4" style="border-top: 1px solid var(--qc-border); padding-top: 20px;">
            <button type="submit" id="submitBtn" disabled class="btn btn-primary" style="font-size: 16px;">
                <span id="btnText">[ REGISTRAR APROVAÇÃO ]</span>
            </button>
            <p id="submitWarning" class="text-center mt-4" style="color: #b91c1c; font-size: 12px; font-weight: bold; display: block;">
                [!] Selecione um Modelo e um Sintoma nas listas para liberar o salvamento.
            </p>
        </div>

    </form>
</div>

<script>
// ==========================================
// LÓGICA FRONT-END (VANILLA JS)
// ==========================================

const DEFEITO_TRANSLATION = {
    "A1": "Sem áudio geral", "A2": "Sem áudio no canal ESQUERDO/Fone", "A3": "Sem áudio no canal DIREITO/Fone",
    "A4": "Sem áudio no MIC/Fone/Aux", "A5": "Ruido no áudio do MIC/Fone/Aux", "A6": "Ruido no áudio",
    "A7": "Vibração no Áudio", "A8": "Mal Contato no MIC/Fone/Aux", "A9": "Sem áudio no Tweteer",
    "A10": "Sem áudio no alto falante", "A11": "Vibração no Áudio SWEEP", "A12": "Volume mínimo não atua",
    "A13": "Áudio Baixo", "A14": "Sem áudio no canal do AF", "AP1": "Liga/desliga automaticamente",
    "AP2": "HI-POT/Rigidez/WI", "BAT1": "Bateria/Pilha não atua", "BAT2": "Aparelho não carrega",
    "BAT3": "Bateria Aux. Não Atua", "BT1": "Bluetooth Não Funciona", "BT2": "Ruido no Bluetooth",
    "BZ": "Buzzer não Atua", "CAP": "Calço/Quadro aparecendo", "CR1": "Controle não atua",
    "CR2": "Controle com pouca sensibilidade", "CR3": "Controle do Game", "CH1": "Chave Não Atua",
    "CONT": "Contaminação", "D1": "Não lê dvd/CD/Jogos", "D2": "CD Sai girando",
    "G1": "Não abre gaveta/Lenta/Batendo", "G2": "Abrindo e fechando automaticamente", "G3": "Gaveta abre mas não fecha",
    "G4": "Loader com ruídos", "GB": "Terra Aberto", "HP1": "Entrada da Gui/Aux Não Funciona",
    "HP2": "Saída Dupla de Áudio", "HP3": "Áudio Oscilando", "HP4": "Osciloscópio com Tensão Variada",
    "HP5": "Repetições de ECO", "HP6": "Agudo/Grave não atua", "HP7": "Pop noise",
    "LAN": "Entrada de Rede não Atua", "L1": "Lâmpada não apaga", "L2": "Lâmpada não Acende",
    "L3": "Lâmpada Fraca/Forte", "L4": "Lâmpada Piscando", "LH": "Linha Horizontal",
    "LV": "Linha Vertical", "LD1": "Led não acende", "LD2": "Led não apaga",
    "LD3": "Led/Flash Light com luz fraca", "LD4": "Led/Flash Light com luz forte", "LD5": "Led/Display piscando",
    "LD6": "Led com cor diferente", "LD7": "Led com luz invertida", "LD8": "Faltando digito no display",
    "LD9": "Excesso de Dígitos", "LD10": "Flash Light não liga", "LD11": "Flash Light Faltando Cor",
    "LD15": "Display não acende", "LD16": "Led do Equalizador não atua", "MURA": "Mancha Escura na Tela",
    "N1": "Aparelho não liga", "N2": "Aparelho não desliga", "N3": "Não Grava/Atualiza",
    "N4": "Software desatualizado", "N5": "Software Travando", "N6": "Centelhando/Ruido",
    "NC": "Não Comunica", "OPT": "Optical não Atual", "OP": "O-cell com Película",
    "OPEN": "Tampa do LOADER Aberto", "P1": "Quebrado/Danificado/Batido", "P2": "Riscado",
    "P3": "Mancha", "P4": "Com rebarba", "P5": "Empenado/Amassado",
    "P6": "Mal montado", "P7": "Abertura/Gap", "P8": "Falha de Injeção /Serigrafia",
    "P9": "Faltando", "P10": "Deslocado", "P11": "Fora do especificado",
    "P12": "Película no O-CELL", "P13": "Aparelho com corpo estranho", "P14": "Espanado",
    "PT1": "Prato não Gira", "PT2": "Prato Travado", "PBR": "Ponto Brilhante",
    "PAP": "Ponto Apagado", "Q1": "Super Aquecimento", "Q2": "Não Aquece",
    "REC": "Função REC não Grava", "RC1": "RCA Fora do especificado", "RC2": "RCA Não atua",
    "RD": "Radio Não Funciona/Sintoniza", "SD": "Falha no SD Card", "ST1": "Sem tensão",
    "ST2": "Tensão baixa", "ST3": "Tensão alta", "ST4": "Tensões variando",
    "ST5": "Placa em Curto", "ST6": "Luz de Jig", "T1": "Teclas não atua",
    "T2": "Tecla deslocada/danificada", "T3": "Função Invertida", "T4": "Tecla dura",
    "T5": "Volume diminui automaticamente", "T6": "Volume máximo não atua", "T7": "Tecla capacitiva (touch) não atua",
    "USB1": "Aparelho não lê pen drive", "USB2": "Mal contato na leitura do pen drive", "V1": "Sem imagem/sem brilho",
    "V2": "Sem vídeo no AV", "V3": "Sem video no HDMI", "V4": "Vídeo com Cor fora de Padrão",
    "V5": "Interferência na Imagem", "V6": "Sem video no RF/ANTENA", "VS1": "Falha Visual/Montagem",
    "VZL": "Vazamento de Luz", "VT1": "Ventilador não Gira", "VT2": "Ruído no Ventilador",
    "VM1": "Vazamento na Cavidade", "VM2": "Vazamento na Porta", "WS": "White Spot",
    "WI-FI": "Sem sinal de wi-fi", "WB": "White Ballance", "TC1": "Tescon Falha de Processo",
    "TC2": "Tescon Material", "GV1": "Gravação Falha de Processo", "GV2": "Gravação Material",
    "DH": "Dip teste Manutenção de equipamento", "PM1": "Potencia Máxima", "PM2": "Potencia Mínima",
    "CTT": "Equipamento de Teste", "VSL": "Equipamento de Teste", "ECJ": "Equipamento de Teste",
    "VPC1": "Equipamento de Teste", "5V": "Equipamento de Teste", "12V": "Equipamento de Teste",
    "CT": "Coating/Selador", "BP1": "Buzzer não Atua", "FF": "Falsa falha",
    "VAR": "Vazamento de AR", "POL": "Polarite Invertido", "VZG": "Vazamento de Gás",
    "ALT": "Aleta não abre/fecha", "A15": "Ruído na Hélice"
};

const SYMPTOMS_LIST = Object.entries(DEFEITO_TRANSLATION).map(([code, description]) => ({ code, description }));

let apiModels = [];

// Elementos DOM
const modelInput = document.getElementById('modelInput');
const modelHidden = document.getElementById('modelHidden');
const modelDropdown = document.getElementById('modelDropdown');

const symptomInput = document.getElementById('symptomInput');
const symptomHidden = document.getElementById('symptomHidden');
const symptomDropdown = document.getElementById('symptomDropdown');

const submitBtn = document.getElementById('submitBtn');
const submitWarning = document.getElementById('submitWarning');
const form = document.getElementById('approvalForm');

// 1. Busca os Modelos na API (Blindado para arrays aninhados)
document.addEventListener('DOMContentLoaded', async () => {
    try {
        const response = await fetch('http://10.110.100.227/qualitycontrol/SIGMA/teste_integracao/uploads/sigma_api.php');
        const dataModels = await response.json();
        
        // Garante que é array
        const arrModels = Array.isArray(dataModels) ? dataModels : (dataModels.data || []);

        const uniqueMap = new Map();
        arrModels.forEach(item => {
            if(item.codigo_prod && item.descricao_prod) {
                uniqueMap.set(String(item.codigo_prod).trim(), {
                    codigo: String(item.codigo_prod).trim(),
                    descricao: String(item.descricao_prod).trim()
                });
            }
        });
        apiModels = Array.from(uniqueMap.values());
        
        modelInput.placeholder = "DIGITE O CÓDIGO OU NOME...";
        modelInput.disabled = false;
    } catch (error) {
        console.error("Erro na API:", error);
        modelInput.placeholder = "ERRO AO CARREGAR MODELOS!";
    }
});

// 2. Trava do Botão (Para cadastro, AMBOS devem estar preenchidos)
function checkFormReadiness() {
    if (modelHidden.value !== '' && symptomHidden.value !== '') {
        submitBtn.disabled = false;
        submitWarning.style.display = 'none';
    } else {
        submitBtn.disabled = true;
        submitWarning.style.display = 'block';
    }
}

// ----------------------------------------------------
// 3. Lógica do Dropdown: MODELOS
// ----------------------------------------------------
function renderModelDropdown(val) {
    modelDropdown.innerHTML = '';
    
    const filtered = apiModels.filter(m => 
        m.codigo.toLowerCase().includes(val) || 
        m.descricao.toLowerCase().includes(val)
    );
    
    if(filtered.length === 0) {
        modelDropdown.innerHTML = '<li style="padding: 12px; text-align: center; color: red; font-weight: bold; font-size: 13px;">[!] NENHUM MODELO ENCONTRADO</li>';
    } else {
        filtered.forEach(m => {
            const li = document.createElement('li');
            li.style.cssText = "padding: 12px 16px; cursor: pointer; border-bottom: 1px solid var(--qc-ice); font-size: 14px; font-weight: bold; color: var(--qc-slate); background: #fff; transition: background 0.2s;";
            
            // Hover via JS
            li.onmouseenter = () => li.style.background = 'var(--qc-green-mint)';
            li.onmouseleave = () => li.style.background = '#fff';
            
            li.innerHTML = `<span style="color: var(--qc-green-forest);">[${m.codigo}]</span> ${m.descricao}`;
            
            // Registra a seleção ANTES do blur
            li.addEventListener('mousedown', (e) => {
                e.preventDefault();
                const str = `[${m.codigo}] ${m.descricao}`;
                modelInput.value = str;
                modelHidden.value = str;
                modelDropdown.style.display = 'none';
                checkFormReadiness();
            });
            modelDropdown.appendChild(li);
        });
    }
    modelDropdown.style.display = 'block';
}

modelInput.addEventListener('input', (e) => {
    modelHidden.value = ''; 
    checkFormReadiness();
    renderModelDropdown(e.target.value.toLowerCase());
});

modelInput.addEventListener('focus', () => { 
    if(apiModels.length > 0) renderModelDropdown(modelInput.value.toLowerCase()); 
});

modelInput.addEventListener('blur', () => {
    setTimeout(() => {
        modelDropdown.style.display = 'none';
        if(modelHidden.value === '') {
            modelInput.value = '';
        }
    }, 200); 
});

// ----------------------------------------------------
// 4. Lógica do Dropdown: SINTOMAS
// ----------------------------------------------------
function renderSymptomDropdown(val) {
    symptomDropdown.innerHTML = '';
    
    const filtered = SYMPTOMS_LIST.filter(s => 
        s.code.toLowerCase().includes(val) || 
        s.description.toLowerCase().includes(val)
    );
    
    if(filtered.length === 0) {
        symptomDropdown.innerHTML = '<li style="padding: 12px; text-align: center; color: red; font-weight: bold; font-size: 13px;">[!] NENHUM SINTOMA ENCONTRADO</li>';
    } else {
        filtered.forEach(s => {
            const li = document.createElement('li');
            li.style.cssText = "padding: 12px 16px; cursor: pointer; border-bottom: 1px solid var(--qc-ice); font-size: 14px; font-weight: bold; color: var(--qc-slate); background: #fff; transition: background 0.2s;";
            
            // Hover via JS
            li.onmouseenter = () => li.style.background = 'var(--qc-green-mint)';
            li.onmouseleave = () => li.style.background = '#fff';
            
            li.innerHTML = `<span style="color: var(--qc-green-forest);">[${s.code}]</span> ${s.description}`;
            
            li.addEventListener('mousedown', (e) => {
                e.preventDefault(); 
                const str = `[${s.code}] ${s.description}`;
                symptomInput.value = str;
                symptomHidden.value = str;
                symptomDropdown.style.display = 'none';
                checkFormReadiness();
            });
            symptomDropdown.appendChild(li);
        });
    }
    symptomDropdown.style.display = 'block';
}

symptomInput.addEventListener('input', (e) => {
    symptomHidden.value = ''; 
    checkFormReadiness();
    renderSymptomDropdown(e.target.value.toLowerCase());
});

symptomInput.addEventListener('focus', () => { 
    renderSymptomDropdown(symptomInput.value.toLowerCase()); 
});

symptomInput.addEventListener('blur', () => {
    setTimeout(() => {
        symptomDropdown.style.display = 'none';
        if(symptomHidden.value === '') {
            symptomInput.value = '';
        }
    }, 200);
});

// ----------------------------------------------------
// 5. Previews de Imagem
// ----------------------------------------------------
function handlePreview(inputId, previewId, textId, textPronto, iconId) {
    document.getElementById(inputId).addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const url = URL.createObjectURL(file);
            const img = document.getElementById(previewId);
            img.src = url;
            img.style.display = 'block';
            document.getElementById(textId).innerText = textPronto;
            
            // Troca o ícone para um 'Check' (Sucesso)
            const iconEl = document.getElementById(iconId);
            if (iconEl) {
                iconEl.innerHTML = `<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline>`;
                iconEl.style.color = "#15803d"; // Verde escuro de sucesso
            }
        }
    });
}

// Passando o ID dos ícones como novo parâmetro para alterar a aparência após o upload
handlePreview('sheetFileInput', 'sheetPreview', 'sheetText', 'FICHA PRONTA', 'sheetIcon');
handlePreview('photoFileInput', 'photoPreview', 'photoText', 'FOTO PRONTA', 'photoIcon');

// ----------------------------------------------------
// 6. Submissão do Formulário via AJAX
// ----------------------------------------------------
form.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const btnText = document.getElementById('btnText');
    btnText.innerText = "[ AGUARDE... SALVANDO ]";
    submitBtn.disabled = true;

    const formData = new FormData(form);

    try {
        const response = await fetch('src/api/salvar_aprovacao.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            document.getElementById('successMessage').style.display = 'block';
            document.getElementById('errorMessage').style.display = 'none';
            form.reset();
            
            modelHidden.value = '';
            symptomHidden.value = '';
            document.getElementById('sheetPreview').style.display = 'none';
            document.getElementById('photoPreview').style.display = 'none';
            document.getElementById('sheetText').innerText = 'ANEXAR FICHA';
            document.getElementById('photoText').innerText = 'ANEXAR FOTO';
            
            // Restaura os ícones originais
            const sheetIcon = document.getElementById('sheetIcon');
            if (sheetIcon) {
                sheetIcon.innerHTML = `<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line>`;
                sheetIcon.style.color = "var(--qc-green-forest)";
            }
            
            const photoIcon = document.getElementById('photoIcon');
            if (photoIcon) {
                photoIcon.innerHTML = `<path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle>`;
                photoIcon.style.color = "var(--qc-green-forest)";
            }

            checkFormReadiness();
        } else {
            throw new Error(result.error);
        }
    } catch (error) {
        const errorEl = document.getElementById('errorMessage');
        errorEl.innerText = `[!] ${error.message || 'ERRO DESCONHECIDO AO SALVAR.'}`;
        errorEl.style.display = 'block';
        document.getElementById('successMessage').style.display = 'none';
    } finally {
        btnText.innerText = "[ REGISTRAR APROVAÇÃO ]";
        checkFormReadiness();
    }
});
</script>

<?php
require_once 'src/views/footer.php';
?>