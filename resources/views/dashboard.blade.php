@extends('web')
@section('content')
<header class="container text-center my-5">
    <h1 class="display-6 fw-bold text-dark text-start">Dashboard - API Токены</h1>
    <p class="text-muted text-start">Управление токенами для доступа к REST API</p>
</header>

<div class="container mb-5">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    
    <div class="row g-4">
        <div class="col-12">
            <div class="card border-secondary">
                <div class="card-header" style="background-color: #283618; color: white;">
                    <h4 class="mb-0"><i class="fas fa-key me-2"></i>API Токены</h4>
                </div>
                <div class="card-body" style="background-color: #f5e5b8;">
                    <div class="mb-4">
                        <button id="create-token-btn" class="btn btn-success me-2">
                            <i class="fas fa-plus me-2"></i>Создать новый токен
                        </button>
                        <button id="refresh-tokens-btn" class="btn btn-secondary">
                            <i class="fas fa-sync-alt me-2"></i>Обновить список
                        </button>
                    </div>

                    <div id="new-token-section" class="mb-4 d-none">
                        <div class="alert alert-success border-2">
                            <h5 class="alert-heading"><i class="fas fa-check-circle me-2"></i>Ваш новый токен:</h5>
                            <div class="bg-white p-3 border border-success mb-3" style="word-break: break-all; font-family: monospace; font-size: 0.9rem;">
                                <code id="new-token-value" class="text-dark"></code>
                            </div>
                            <p class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i><strong>Важно:</strong> Скопируйте этот токен сейчас. Вы не сможете увидеть его снова!</p>
                            <button class="btn btn-sm btn-outline-success mt-2" onclick="copyToken()">
                                <i class="fas fa-copy me-2"></i>Скопировать токен
                            </button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5 class="mb-3"><i class="fas fa-list me-2"></i>Активные токены:</h5>
                        <div id="tokens-list">
                            <div class="text-muted">
                                <i class="fas fa-spinner fa-spin me-2"></i>Загрузка токенов...
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 border-top pt-4">
                        <h5 class="mb-3"><i class="fas fa-info-circle me-2"></i>Как использовать API:</h5>
                        <ol class="mb-3">
                            <li>Создайте новый токен, нажав кнопку "Создать новый токен"</li>
                            <li>Скопируйте полученный токен</li>
                            <li>Используйте токен в заголовке запроса: <code>Authorization: Bearer YOUR_TOKEN</code></li>
                            <li>Доступные endpoints: <code>/api/cities</code>, <code>/api/comments</code></li>
                        </ol>
                        <a href="/tmp_rovodev_API_TESTING_GUIDE.md" class="btn btn-outline-primary btn-sm" target="_blank">
                            <i class="fas fa-book me-2"></i>Документация API
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Load tokens on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadTokens();
    });

    // Create new token
    document.getElementById('create-token-btn').addEventListener('click', function() {
        const tokenName = prompt('Введите имя для токена:', 'API Token');
        if (!tokenName) return;

        axios.post('/oauth/personal-access-tokens', {
            name: tokenName,
            scopes: []
        })
        .then(response => {
            // Show the new token
            document.getElementById('new-token-value').textContent = response.data.accessToken;
            document.getElementById('new-token-section').classList.remove('d-none');
            
            // Reload tokens list
            loadTokens();
        })
        .catch(error => {
            console.error('Error creating token:', error);
            alert('Ошибка при создании токена. Попробуйте снова.');
        });
    });

    // Refresh tokens list
    document.getElementById('refresh-tokens-btn').addEventListener('click', function() {
        loadTokens();
    });

    // Copy token to clipboard
    function copyToken() {
        const tokenValue = document.getElementById('new-token-value').textContent;
        navigator.clipboard.writeText(tokenValue).then(() => {
            alert('Токен скопирован в буфер обмена!');
        }).catch(err => {
            console.error('Error copying token:', err);
            alert('Не удалось скопировать токен. Скопируйте вручную.');
        });
    }

    // Load tokens from API
    function loadTokens() {
        axios.get('/oauth/personal-access-tokens')
        .then(response => {
            const tokensList = document.getElementById('tokens-list');
            tokensList.innerHTML = '';

            if (response.data.length === 0) {
                tokensList.innerHTML = '<div class="alert alert-info"><i class="fas fa-info-circle me-2"></i>Токены не найдены. Создайте первый токен для начала работы!</div>';
            } else {
                const table = document.createElement('div');
                table.className = 'table-responsive';
                
                let tableHTML = '<table class="table table-hover table-bordered"><thead class="table-light"><tr><th>Название</th><th>Клиент</th><th>Создан</th><th>Действия</th></tr></thead><tbody>';
                
                response.data.forEach(token => {
                    tableHTML += `
                        <tr>
                            <td><strong>${token.name}</strong></td>
                            <td>${token.client.name}</td>
                            <td><small>${new Date(token.created_at).toLocaleString('ru-RU')}</small></td>
                            <td>
                                <button class="btn btn-sm btn-danger" onclick="revokeToken('${token.id}')">
                                    <i class="fas fa-trash me-1"></i>Отозвать
                                </button>
                            </td>
                        </tr>
                    `;
                });
                
                tableHTML += '</tbody></table>';
                table.innerHTML = tableHTML;
                tokensList.appendChild(table);
            }
        })
        .catch(error => {
            console.error('Error loading tokens:', error);
            document.getElementById('tokens-list').innerHTML = 
                '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i>Ошибка загрузки токенов. Обновите страницу.</div>';
        });
    }

    // Revoke a token
    function revokeToken(tokenId) {
        if (!confirm('Вы уверены, что хотите отозвать этот токен?')) return;

        axios.delete('/oauth/personal-access-tokens/' + tokenId)
        .then(response => {
            loadTokens();
            alert('Токен успешно отозван!');
        })
        .catch(error => {
            console.error('Error revoking token:', error);
            alert('Ошибка при отзыве токена. Попробуйте снова.');
        });
    }
</script>
@endsection
