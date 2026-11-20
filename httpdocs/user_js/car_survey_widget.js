window.CarSurveyWidget = (function () {
    const instances = {};

    function drawRoundedRect(ctx, x, y, w, h, r) {
        ctx.beginPath();
        ctx.moveTo(x + r, y);
        ctx.lineTo(x + w - r, y);
        ctx.quadraticCurveTo(x + w, y, x + w, y + r);
        ctx.lineTo(x + w, y + h - r);
        ctx.quadraticCurveTo(x + w, y + h, x + w - r, y + h);
        ctx.lineTo(x + r, y + h);
        ctx.quadraticCurveTo(x, y + h, x, y + h - r);
        ctx.lineTo(x, y + r);
        ctx.quadraticCurveTo(x, y, x + r, y);
        ctx.closePath();
    }

    function render(inst) {
        const { canvas, marks } = inst;
        const ctx = canvas.getContext('2d');
        const W = canvas.width;
        const H = canvas.height;
        const cx = W / 2;
        const cy = H / 2;
        const sx = 160; // 40mm * 4
        const sy = 80;  // 20mm * 4
        const mm = 4;   // 4px per mm

        ctx.clearRect(0, 0, W, H);
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, W, H);

        ctx.strokeStyle = '#334155';
        ctx.lineWidth = 1.4;

        // Car outer body (80x40mm)
        drawRoundedRect(ctx, cx - 40 * mm, cy - 20 * mm, 80 * mm, 40 * mm, 8 * mm);
        ctx.stroke();

        // Hood
        drawRoundedRect(ctx, cx - 34 * mm, cy - 14 * mm, 18 * mm, 28 * mm, 3 * mm);
        ctx.stroke();

        // Windshield
        ctx.strokeRect(cx - 14 * mm, cy - 14 * mm, 7 * mm, 28 * mm);

        // Roof
        ctx.strokeRect(cx - 5 * mm, cy - 13 * mm, 18 * mm, 26 * mm);

        // Rear Window
        ctx.strokeRect(cx + 15 * mm, cy - 14 * mm, 7 * mm, 28 * mm);

        // Trunk
        drawRoundedRect(ctx, cx + 24 * mm, cy - 14 * mm, 12 * mm, 28 * mm, 3 * mm);
        ctx.stroke();

        // Doors
        ctx.strokeRect(cx - 10 * mm, cy - 20 * mm, 12 * mm, 5 * mm);
        ctx.strokeRect(cx + 4 * mm, cy - 20 * mm, 12 * mm, 5 * mm);
        ctx.strokeRect(cx - 10 * mm, cy + 15 * mm, 12 * mm, 5 * mm);
        ctx.strokeRect(cx + 4 * mm, cy + 15 * mm, 12 * mm, 5 * mm);

        // 4 CAP wheels
        const wheels = [[-24, -22], [22, -22], [-24, 22], [22, 22]];
        wheels.forEach(([wx, wy]) => {
            ctx.beginPath();
            ctx.arc(cx + wx * mm, cy + wy * mm, 4.2 * mm, 0, Math.PI * 2);
            ctx.fillStyle = '#1e293b';
            ctx.fill();
            ctx.fillStyle = '#ffffff';
            ctx.font = 'bold 9px sans-serif';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText('CAP', cx + wx * mm, cy + wy * mm);
        });

        // Labels
        ctx.fillStyle = '#475569';
        ctx.font = 'bold 10px sans-serif';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillText('HOOD', cx - 25 * mm, cy);
        ctx.fillText('ROOF', cx + 4 * mm, cy);
        ctx.fillText('TRUNK', cx + 30 * mm, cy);
        ctx.font = '9px sans-serif';
        ctx.fillText('DOOR', cx - 4 * mm, cy - 17.5 * mm);
        ctx.fillText('DOOR', cx + 10 * mm, cy - 17.5 * mm);
        ctx.fillText('DOOR', cx - 4 * mm, cy + 17.5 * mm);
        ctx.fillText('DOOR', cx + 10 * mm, cy + 17.5 * mm);

        // Draw marks
        (marks || []).forEach(m => {
            ctx.strokeStyle = '#dc2626';
            ctx.lineCap = 'round';
            ctx.lineJoin = 'round';
            if (m.type === 'x') {
                const px = cx + m.nx * sx;
                const py = cy + m.ny * sy;
                ctx.lineWidth = 2.6;
                ctx.beginPath();
                ctx.moveTo(px - 6, py - 6);
                ctx.lineTo(px + 6, py + 6);
                ctx.moveTo(px + 6, py - 6);
                ctx.lineTo(px - 6, py + 6);
                ctx.stroke();
            } else if (m.type === 'line' && Array.isArray(m.pts) && m.pts.length > 1) {
                ctx.lineWidth = 2.4;
                ctx.beginPath();
                m.pts.forEach((pt, i) => {
                    const px = cx + pt.nx * sx;
                    const py = cy + pt.ny * sy;
                    if (i === 0) ctx.moveTo(px, py);
                    else ctx.lineTo(px, py);
                });
                ctx.stroke();
            }
        });
    }

    function getNormCoords(canvas, clientX, clientY) {
        const rect = canvas.getBoundingClientRect();
        const px = ((clientX - rect.left) / rect.width) * canvas.width;
        const py = ((clientY - rect.top) / rect.height) * canvas.height;
        return {
            nx: parseFloat(((px - canvas.width / 2) / 160).toFixed(4)),
            ny: parseFloat(((py - canvas.height / 2) / 80).toFixed(4))
        };
    }

    function init(canvasId, initialMarks = [], options = {}) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) return null;
        const inst = {
            canvas,
            marks: Array.isArray(initialMarks) ? JSON.parse(JSON.stringify(initialMarks)) : [],
            mode: options.mode || 'x',
            readOnly: !!options.readOnly,
            drawing: false,
            currentLine: null
        };
        instances[canvasId] = inst;
        render(inst);

        if (inst.readOnly) return inst;

        const onDown = (clientX, clientY) => {
            const pt = getNormCoords(canvas, clientX, clientY);
            if (inst.mode === 'x') {
                inst.marks.push({ type: 'x', nx: pt.nx, ny: pt.ny });
                render(inst);
            } else {
                inst.drawing = true;
                inst.currentLine = { type: 'line', pts: [pt] };
                inst.marks.push(inst.currentLine);
                render(inst);
            }
        };

        const onMove = (clientX, clientY) => {
            if (!inst.drawing || !inst.currentLine) return;
            const pt = getNormCoords(canvas, clientX, clientY);
            inst.currentLine.pts.push(pt);
            render(inst);
        };

        const onUp = () => {
            if (inst.drawing && inst.currentLine && inst.currentLine.pts.length < 2) {
                const pt = inst.currentLine.pts[0];
                inst.marks[inst.marks.length - 1] = { type: 'x', nx: pt.nx, ny: pt.ny };
                render(inst);
            }
            inst.drawing = false;
            inst.currentLine = null;
        };

        canvas.onmousedown = e => onDown(e.clientX, e.clientY);
        canvas.onmousemove = e => onMove(e.clientX, e.clientY);
        window.addEventListener('mouseup', onUp);

        canvas.ontouchstart = e => {
            if (e.touches.length) {
                e.preventDefault();
                onDown(e.touches[0].clientX, e.touches[0].clientY);
            }
        };
        canvas.ontouchmove = e => {
            if (e.touches.length) {
                e.preventDefault();
                onMove(e.touches[0].clientX, e.touches[0].clientY);
            }
        };
        canvas.ontouchend = () => onUp();

        return inst;
    }

    return {
        init,
        setMode(canvasId, mode) {
            if (instances[canvasId]) instances[canvasId].mode = mode;
        },
        undo(canvasId) {
            const inst = instances[canvasId];
            if (inst && inst.marks.length > 0) {
                inst.marks.pop();
                render(inst);
            }
        },
        clear(canvasId) {
            const inst = instances[canvasId];
            if (inst) {
                inst.marks = [];
                render(inst);
            }
        },
        setMarks(canvasId, marks) {
            const inst = instances[canvasId];
            if (inst) {
                inst.marks = Array.isArray(marks) ? JSON.parse(JSON.stringify(marks)) : [];
                render(inst);
            }
        },
        getMarks(canvasId) {
            return instances[canvasId] ? instances[canvasId].marks : [];
        }
    };
})();
