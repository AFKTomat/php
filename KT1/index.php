<?php
session_start();

if (!isset($_SESSION['dialogue'])) {
    $_SESSION['dialogue'] = [];
    $_SESSION['countPoka'] = 0;
    $_SESSION['active'] = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message']) && $_SESSION['active']) {
    $message = trim($_POST['message']);
    
    if (!empty($message)) {
        $_SESSION['dialogue'][] = [
            'type' => 'user', 
            'text' => $message, 
            'time' => date('H:i')
        ];
        
        $response = getGrandmaResponse($message, $_SESSION['countPoka'], $_SESSION['active']);
        
        $_SESSION['dialogue'][] = [
            'type' => 'grandma', 
            'text' => $response, 
            'time' => date('H:i')
        ];
    }
}

function ruStrtoupper($string) {
    $lower = [
        'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я'
    ];
    $upper = [
        'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я'
    ];
    
    return str_replace($lower, $upper, strtoupper($string));
}

function getGrandmaResponse($input, &$countPoka, &$active) {
    
    $upperInput = ruStrtoupper($input);
    
    error_log("Входное сообщение: " . $input);
    error_log("В верхнем регистре: " . $upperInput);
    error_log("Текущий счетчик: " . $countPoka);
    
    if ($upperInput === 'ПОКА!' || $upperInput === 'ПОКА' || $upperInput === 'ПОКА!!') {
        $countPoka++;
        error_log("Счетчик увеличен: " . $countPoka);
        
        if ($countPoka >= 3) {
            $active = false;
            error_log("Диалог завершен!");
            return "ДО СВИДАНИЯ, МИЛЫЙ! ЗАХОДИ ЕЩЁ!";
        } else {
            $year = rand(1930, 1950);
            return "НЕТ, НИ РАЗУ С $year ГОДА!";
        }
    } else {
        $countPoka = 0;
    }
    if (substr($input, -1) === '!') {
        $year = rand(1930, 1950);
        return "НЕТ, НИ РАЗУ С $year ГОДА!";
    } else {
        return "АСЬ?! ГОВОРИ ГРОМЧЕ, ВНУЧЕК!";
    }
}

if (isset($_POST['reset'])) {
    session_destroy();
    session_start();
    $_SESSION['dialogue'] = [];
    $_SESSION['countPoka'] = 0;
    $_SESSION['active'] = true;
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Глухая бабушка</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fa;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: #2c3e50;
        }

        .container {
            max-width: 900px;
            width: 100%;
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #eef2f6;
        }

        .header {
            background: #ffffff;
            padding: 32px 24px;
            text-align: center;
            border-bottom: 1px solid #eef2f6;
        }

        .header h1 {
            font-size: 2.2em;
            margin-bottom: 8px;
            font-weight: 600;
            color: #1e293b;
            letter-spacing: -0.5px;
        }

        .header p {
            font-size: 1em;
            color: #64748b;
            font-weight: 400;
        }

        .status {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 100px;
            font-size: 0.85em;
            margin-top: 16px;
            font-weight: 500;
            letter-spacing: 0.3px;
            background: #f1f5f9;
            color: #475569;
        }

        .status.active {
            background: #1e293b;
            color: #ffffff;
        }

        .status.inactive {
            background: #e2e8f0;
            color: #64748b;
        }

        .chat-container {
            height: 450px;
            overflow-y: auto;
            padding: 24px;
            background: #fafbfc;
        }

        .chat-container::-webkit-scrollbar {
            width: 6px;
        }

        .chat-container::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .chat-container::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .chat-container::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .message {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
            animation: fadeIn 0.2s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .message.user {
            align-items: flex-end;
        }

        .message.grandma {
            align-items: flex-start;
        }

        .message-content {
            max-width: 70%;
            padding: 12px 18px;
            border-radius: 16px;
            word-wrap: break-word;
            font-size: 0.95em;
            line-height: 1.5;
            font-weight: 400;
        }

        .message.user .message-content {
            background: #1e293b;
            color: #ffffff;
            border-bottom-right-radius: 4px;
        }

        .message.grandma .message-content {
            background: #ffffff;
            color: #1e293b;
            border-bottom-left-radius: 4px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .message-meta {
            font-size: 0.7em;
            color: #94a3b8;
            margin-top: 6px;
            padding: 0 4px;
            font-weight: 400;
            letter-spacing: 0.2px;
        }

        .message.user .message-meta {
            color: #94a3b8;
        }

        .welcome-message {
            background: #ffffff;
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            text-align: center;
            color: #1e293b;
            font-size: 1em;
            border: 1px solid #e2e8f0;
            font-weight: 500;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .input-area {
            padding: 24px;
            background: #ffffff;
            border-top: 1px solid #eef2f6;
        }

        .input-form {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
        }

        .message-input {
            flex: 1;
            padding: 14px 18px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.95em;
            outline: none;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            color: #1e293b;
        }

        .message-input::placeholder {
            color: #94a3b8;
            font-weight: 300;
        }

        .message-input:focus {
            border-color: #1e293b;
            box-shadow: 0 0 0 3px rgba(30, 41, 59, 0.1);
        }

        .message-input:disabled {
            background: #f8fafc;
            border-color: #e2e8f0;
            color: #94a3b8;
            cursor: not-allowed;
        }

        .send-btn {
            padding: 14px 32px;
            background: #1e293b;
            color: #ffffff;
            border: none;
            border-radius: 12px;
            font-size: 0.95em;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            letter-spacing: 0.3px;
            white-space: nowrap;
        }

        .send-btn:hover:not(:disabled) {
            background: #0f172a;
        }

        .send-btn:disabled {
            background: #e2e8f0;
            color: #94a3b8;
            cursor: not-allowed;
        }

        .reset-btn {
            width: 100%;
            padding: 12px;
            background: transparent;
            color: #64748b;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.9em;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            letter-spacing: 0.3px;
        }

        .reset-btn:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            color: #1e293b;
        }

        .rules {
            padding: 20px 24px;
            background: #f8fafc;
            border-top: 1px solid #eef2f6;
        }

        .rules h3 {
            font-size: 0.9em;
            color: #64748b;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .rules ul {
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            gap: 24px;
        }

        .rules li {
            font-size: 0.85em;
            color: #475569;
            position: relative;
            padding-left: 20px;
            line-height: 1.5;
            font-weight: 400;
        }

        .rules li::before {
            content: '—';
            position: absolute;
            left: 0;
            color: #94a3b8;
        }

        .rules li strong {
            color: #1e293b;
            font-weight: 600;
            background: #f1f5f9;
            padding: 2px 8px;
            border-radius: 6px;
            margin-right: 4px;
        }

        @media (max-width: 600px) {
            .container {
                border-radius: 20px;
            }
            
            .header h1 {
                font-size: 1.8em;
            }
            
            .input-form {
                flex-direction: column;
            }
            
            .send-btn {
                width: 100%;
            }
            
            .message-content {
                max-width: 85%;
            }
            
            .rules ul {
                flex-direction: column;
                gap: 8px;
            }
            
            .rules li {
                padding-left: 16px;
            }
        }

        .message:last-child {
            animation: slideIn 0.2s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Глухая бабушка</h1>
            <p>беседа по душам</p>
            <div class="status <?php echo $_SESSION['active'] ? 'active' : 'inactive'; ?>">
                <?php echo $_SESSION['active'] ? 'бабушка слушает' : 'разговор окончен'; ?>
            </div>
        </div>
        
        <div class="chat-container" id="chatContainer">
            <div class="welcome-message">
                ЧЕГО СКАЗАТЬ-ТО ХОТЕЛ, МИЛОК?!
            </div>
            
            <?php foreach ($_SESSION['dialogue'] as $msg): ?>
                <div class="message <?php echo $msg['type']; ?>">
                    <div class="message-content">
                        <?php echo htmlspecialchars($msg['text']); ?>
                    </div>
                    <div class="message-meta">
                        <?php echo $msg['type'] === 'user' ? 'Вы' : 'Бабушка'; ?> • <?php echo $msg['time']; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="input-area">
            <form method="POST" class="input-form" id="messageForm">
                <input type="text" 
                       name="message" 
                       class="message-input" 
                       placeholder="Напишите что-нибудь..." 
                       autocomplete="off"
                       <?php echo !$_SESSION['active'] ? 'disabled' : ''; ?>
                       required>
                <button type="submit" class="send-btn" <?php echo !$_SESSION['active'] ? 'disabled' : ''; ?>>
                    Сказать
                </button>
            </form>
            
            <form method="POST">
                <button type="submit" name="reset" class="reset-btn">
                    Начать заново
                </button>
            </form>
        </div>
        
        <div class="rules">
            <h3>Правила общения</h3>
            <ul>
                <li><strong>Тихо</strong> — без !, бабушка не слышит</li>
                <li><strong>Громко</strong> — с !, бабушка отвечает годом</li>
                <li><strong>Пока!</strong> — 3 раза подряд для прощания</li>
            </ul>
        </div>
    </div>
    
    <script>
        const chatContainer = document.getElementById('chatContainer');
        
        chatContainer.scrollTop = chatContainer.scrollHeight;
        
        document.getElementById('messageForm').addEventListener('submit', function() {
            setTimeout(() => {
                document.querySelector('.message-input').value = '';
            }, 10);
        });
        
        const messageInput = document.querySelector('.message-input:not(:disabled)');
        if (messageInput) {
            messageInput.focus();
        }
        
        const observer = new MutationObserver(() => {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        });
        
        observer.observe(chatContainer, { childList: true, subtree: true });
    </script>
</body>
</html>
