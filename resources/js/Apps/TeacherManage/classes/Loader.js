export default class Loader {
    constructor() {
        this.overlay = document.createElement('div');
        this.overlay.style.cssText = `
            position: fixed;
            background: #ffffff;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1000;
        `;
        this.overlay.style.display = 'none';
        this.overlay.innerHTML = `
            <div style="position: relative;width: 100vw; height: 100vh; display: flex; flex-direction: column; gap: 10px; justify-content: center; align-items: center;" class="loader__content">
                <div style="position: relative;">
                    <svg class="loader__progress-ring" width="120" height="120">
                        <circle
                            id="loader__progress-circle"
                            stroke="#4796b4"
                            stroke-width="4"
                            cx="60"
                            cy="60"
                            r="52"
                            fill="transparent"
                            style="transform-origin: center; transform: rotate(-90deg); transition: stroke-dashoffset 0.3s;"
                        />
                    </svg>
                    <span style="position: absolute; top: 50%; left: 50%; transform: translateX(-50%) translateY(-50%);" id="loader__progress-label">0</span>
                </div>

                <span id="loader__progress-title" style="display: none; text-align: center;"></span>
            </div>
        `;
        document.body.append(this.overlay);
        this.circle = document.getElementById('loader__progress-circle');
        this.radius = this.circle.r.baseVal.value;
        this.circumference = 2 * Math.PI * this.radius;
        this.circle.style.strokeDasharray = `${this.circumference} ${this.circumference}`;
        this.circle.style.strokeDashoffset = this.circumference;
    }

    setProgress(percent) {
        const offset = this.circumference - percent / 100 * this.circumference;
        this.circle.style.strokeDashoffset = offset;
    }

    show(title = null) {
        document.body.style.overflow = 'hidden';
        if(title) {
            document.getElementById('loader__progress-title').style.display = 'block';
            document.getElementById('loader__progress-title').innerText = title;
        }
        this.overlay.style.display = 'block';
        this.setProgress(0);
        this.setLabelPercent(0);
    }

    updateProgress(progressEvent) {
        const percent = Math.round((progressEvent.loaded / progressEvent.total) * 100);
        console.log(percent);
        this.setLabelPercent(percent);
        this.setProgress(percent);
        if(percent == 100) {
            this.close();
        }
    }

    setLabelPercent(percent) {
        document.getElementById('loader__progress-label').innerText = percent;
    }

    close() {
        setInterval(() => {
            document.body.style.overflow = 'unset';
            this.overlay.style.display = 'none';
            document.getElementById('loader__progress-title').style.display = 'none';
        }, 1000);
    }
};
