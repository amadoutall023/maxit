

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maxitsa Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
       
        .rainbow-gradient {
            background: linear-gradient(135deg, #ff6b35, #f7931e, #ffd23f, #00b894, #00cec9, #0984e3);
            border-radius: 0 0 24px 24px;
            position: relative;
            overflow: hidden;
        }
        
        .rainbow-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 400px;
            height: 100%;
            background: linear-gradient(135deg, 
                rgba(255, 107, 53, 0.8) 0%,
                rgba(247, 147, 30, 0.8) 20%,
                rgba(255, 210, 63, 0.8) 40%,
                rgba(0, 184, 148, 0.8) 60%,
                rgba(0, 206, 201, 0.8) 80%,
                rgba(9, 132, 227, 0.8) 100%
            );
            border-radius: 50% 0 0 50%;
            transform: translateX(150px);
        }
        
        .balance-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar {
            background: linear-gradient(180deg, #2d3748 0%, #1a202c 100%);
        }
        
        .transaction-item {
            transition: all 0.3s ease;
        }
        
        .transaction-item:hover {
            background-color: #f7fafc;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .action-button {
            transition: all 0.3s ease;
        }
        
        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 107, 53, 0.3);
        }
        
        .sidebar-toggle {
            transition: all 0.3s ease;
        }
        
        .sidebar-toggle:hover {
            background-color: #f97316;
        }
    </style>
   
</head>
<body class="bg-gray-100 flex h-screen">

            <?php require_once '../templates/layout/partial/leftbar.php'; ?>
 <?php require_once '../templates/layout/partial/header.html.php'; ?>

            
            <main class="flex-1 overflow-y-auto p-6 bg-gray-100">

     <?php echo $contentForLayout; ?>

            </main>
      
</body>
</html>




