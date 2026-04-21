<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AA Car Rental - Custom Quotation Generator</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #ed1c24;
            --secondary: #2c3e50;
            --bg: #f4f7f6;
            --card-bg: #ffffff;
            --text: #333333;
            --border: #e1e8ed;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 800px;
            padding: 20px;
        }

        .card {
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            padding: 40px;
            border: 1px solid var(--border);
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header img {
            max-width: 150px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--secondary);
            margin: 0;
        }

        .header p {
            color: #7f8c8d;
            font-size: 14px;
            margin-top: 5px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .full-width {
            grid-column: span 2;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        input,
        select,
        textarea {
            padding: 12px 15px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s, box-shadow 0.3s;
            font-family: 'Inter', sans-serif;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(237, 28, 36, 0.1);
        }

        .btn-generate {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s, transform 0.2s;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 20px;
        }

        .btn-generate:hover {
            background-color: #c0181e;
            transform: translateY(-2px);
        }

        .btn-generate:active {
            transform: translateY(0);
        }

        .btn-v2 {
            background-color: var(--secondary);
            margin-top: 10px;
        }

        .btn-v2:hover {
            background-color: #1a252f;
        }

        .footer-note {
            text-align: center;
            font-size: 12px;
            color: #95a5a6;
            margin-top: 30px;
        }

        /* Micro-animations */
        .form-group {
            animation: fadeIn 0.5s ease backwards;
        }

        @keyframes fadeIn {
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
        <div class="card">
            <div class="header">
                <img src="../assets/img/logo/logo.png" width="80%" alt="AA CAR RENTAL">
                <h1>Quotation Configurator</h1>
                <p>Adjust parameters to generate a professional PDF in a new tab.</p>
            </div>

            <form action="generate_quotation.php" method="POST" target="_blank" id="configForm">
                <div class="form-grid">
                    <!-- ID is NOT stored in localStorage as per request -->
                    <div class="form-group full-width">
                        <label for="id">Quotation ID (from Database)</label>
                        <input type="hidden" name="id" id="id" value='<?php echo $_GET['id'];?>' required>
                        <input type="text" name="refNo" id="refNo" value='<?php echo $_GET['ref_no'];?>' required>
                    </div>

                    <div class="form-group">
                        <label for="orientation">Page Orientation</label>
                        <select name="orientation" id="orientation">
                            <option value="L">Landscape (Optimized)</option>
                            <option value="P">Portrait</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="font_size_table">Table Font Size (Table Content)</label>
                        <input type="number" step="0.5" name="font_size_table" id="font_size_table" value="8" min="6"
                            max="14">
                    </div>

                    <div class="form-group">
                        <label for="footer_logo_x">Bottom Logo X-Pos (mm)</label>
                        <input type="number" name="footer_logo_x" id="footer_logo_x" value="15">
                    </div>

                    <div class="form-group">
                        <label for="footer_logo_y">Bottom Logo Y-Pos (mm from bottom) <span id="page_h_hint"
                                style="color:var(--primary); font-size:10px;">(Max ~210)</span></label>
                        <input type="number" name="footer_logo_y" id="footer_logo_y" value="-35"
                            placeholder="Use negative for bottom offset">
                    </div>

                    <div class="form-group">
                        <label for="page_break_threshold">Page Break Threshold (mm)</label>
                        <input type="number" name="page_break_threshold" id="page_break_threshold" value="30" min="5"
                            max="100">
                    </div>

                    <!-- Last Page Seal Only -->
                    <div class="form-group full-width"
                        style="margin-top: 20px; border-top: 1px solid var(--border); padding-top: 20px;">
                        <h3 style="font-size: 1.1rem; color: var(--primary); margin-bottom: 5px;">Seal & Signature (Last
                            Page)</h3>
                        <p style="font-size: 12px; color: #7f8c8d; margin-bottom: 15px;">Placement for the final page of
                            the document.</p>
                    </div>

                    <div class="form-group" id="seal_last_x_group" style="display:none;">
                        <label for="seal_last_x">Last Page Seal X (mm)</label>
                        <input type="number" name="seal_last_x" id="seal_last_x" value="160">
                    </div>

                    <div class="form-group" id="seal_last_y_group" style="display:none;">
                        <label for="seal_last_y">Last Page Seal Y position (mm) <span class="max-h-text"
                                style="color:var(--primary); font-size:10px;">(Max ~210)</span></label>
                        <input type="number" name="seal_last_y" id="seal_last_y" value="0"
                            placeholder="Use 0 for bottom-right default">
                    </div>

                    <div class="form-group" id="seal_last_x_group_alt" style="display:none;">
                        <label>Info:</label>
                        <div
                            style="font-size:11px; color:#7f8c8d; background:#f9f9f9; padding:10px; border-radius:5px;">
                            <b>A4 Portrait:</b> 210 x 297mm<br>
                            <b>A4 Landscape:</b> 297 x 210mm
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label for="seal_last_pg">Seal & Signature Placement:</label>
                        <select name="seal_last_pg" id="seal_last_pg">
                            <option value="none">None / Hidden</option>
                            <option value="last_left" selected>All Pages - Bottom Left</option>
                            <option value="last_center">All Pages - Bottom Center</option>
                            <option value="last_right">All Pages - Bottom Right</option>
                            <option value="last_custom">Last Page Only - Custom Position</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn-generate">Generate Standard Quotation</button>
                <button type="submit" formaction="generate_quotation_v2.php" class="btn-generate btn-v2">Generate Quotation V2 (With Images)</button>
            </form>

            <div class="footer-note">
                &copy; 2026 AA CAR RENTAL CO. W.L.L | All settings (except ID) are saved locally for convenience.
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('configForm');
        const storageKey = 'aa_qtn_form_settings';

        // List of keys to save and restore from localStorage
        const persistKeys = [
            'orientation',
            'font_size_table',
            'footer_logo_x',
            'footer_logo_y',
            'footer_logo_pg',
            'page_break_threshold',
            'seal_last_pg',
            'seal_last_x',
            'seal_last_y'
        ];

        // Save settings on change
        form.addEventListener('change', () => {
            const data = {};
            persistKeys.forEach(key => {
                const el = document.getElementById(key);
                if (el) data[key] = el.value;
            });
            localStorage.setItem(storageKey, JSON.stringify(data));
            toggleCustomSealFields(); // Check visibility
            updateOrientationHints(); // Update max height hints
        });

        function updateOrientationHints() {
            const orientation = document.getElementById('orientation').value;
            const maxH = (orientation === 'L') ? 210 : 297;
            const maxW = (orientation === 'L') ? 297 : 210;

            document.querySelectorAll('.max-h-text').forEach(el => {
                el.innerText = `(Max ~${maxH}mm)`;
            });
            document.getElementById('page_h_hint').innerText = `(Max ~${maxH}mm)`;

            // Highlight inputs if they exceed current orientation limit
            const input = document.getElementById('seal_last_y');
            if (input && input.value > maxH) {
                input.style.borderColor = 'red';
                input.style.backgroundColor = '#fff0f0';
            } else if (input) {
                input.style.borderColor = '';
                input.style.backgroundColor = '';
            }
        }

        function toggleCustomSealFields() {
            // Last Page Only
            const sealLastPg = document.getElementById('seal_last_pg').value;
            document.getElementById('seal_last_x_group').style.display = (sealLastPg === 'last_custom') ? 'block' : 'none';
            document.getElementById('seal_last_y_group').style.display = (sealLastPg === 'last_custom') ? 'block' : 'none';
            document.getElementById('seal_last_x_group_alt').style.display = (sealLastPg === 'last_custom') ? 'block' : 'none';
        }

        // Load settings on load
        window.addEventListener('DOMContentLoaded', () => {
            const savedData = localStorage.getItem(storageKey);
            if (savedData) {
                const data = JSON.parse(savedData);
                persistKeys.forEach(key => {
                    if (data[key] !== undefined) {
                        const el = document.getElementById(key);
                        if (el) el.value = data[key];
                    }
                });
            }
            toggleCustomSealFields(); // Initial check
            updateOrientationHints(); // Initial hints
        });

        // Also save on submit just in case
        form.addEventListener('submit', () => {
            const data = {};
            persistKeys.forEach(key => {
                const el = document.getElementById(key);
                if (el) data[key] = el.value;
            });
            localStorage.setItem(storageKey, JSON.stringify(data));
        });
    </script>

</body>

</html>