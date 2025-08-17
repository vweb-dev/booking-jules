const UI = {
    reels: [],
    currentReelIndex: 0,
    viewer: null,
    nextButton: null,
    prevButton: null,

    initExploreFeed: async function() {
        this.viewer = document.getElementById('reel-viewer');
        this.nextButton = document.getElementById('next-reel');
        this.prevButton = document.getElementById('prev-reel');

        if (!this.viewer || !this.nextButton || !this.prevButton) {
            console.error('Required UI elements not found for the reel viewer.');
            return;
        }

        this.nextButton.addEventListener('click', () => this.showNextReel());
        this.prevButton.addEventListener('click', () => this.showPrevReel());

        try {
            this.reels = await Http.get('/api/public/feed.php');
            if (this.reels.length > 0) {
                this.renderReel();
            } else {
                this.showEmptyMessage();
            }
        } catch (error) {
            this.showErrorMessage();
        }
    },

    renderReel: function() {
        if (!this.reels.length) return;

        const reel = this.reels[this.currentReelIndex];
        this.viewer.innerHTML = ''; // Clear previous content

        const reelItem = document.createElement('div');
        reelItem.className = 'reel-item active';

        let mediaElement;
        if (reel.media_type === 'video') {
            mediaElement = document.createElement('video');
            mediaElement.src = '/' + reel.file_path;
            mediaElement.autoplay = true;
            mediaElement.muted = true; // Autoplay often requires mute
            mediaElement.loop = true;
            mediaElement.playsInline = true;
        } else {
            mediaElement = document.createElement('img');
            mediaElement.src = '/' + reel.file_path;
            mediaElement.alt = `Talent: ${reel.first_name}`;
        }

        const infoElement = document.createElement('div');
        infoElement.className = 'reel-info';
        infoElement.innerHTML = `<p>${reel.first_name}</p>`;

        reelItem.appendChild(mediaElement);
        reelItem.appendChild(infoElement);
        this.viewer.appendChild(reelItem);

        this.updateNavButtons();
    },

    showNextReel: function() {
        if (this.currentReelIndex < this.reels.length - 1) {
            this.currentReelIndex++;
            this.renderReel();
        }
    },

    showPrevReel: function() {
        if (this.currentReelIndex > 0) {
            this.currentReelIndex--;
            this.renderReel();
        }
    },

    updateNavButtons: function() {
        this.prevButton.disabled = this.currentReelIndex === 0;
        this.nextButton.disabled = this.currentReelIndex === this.reels.length - 1;
    },

    showEmptyMessage: function() {
        this.viewer.innerHTML = '<div class="reel-item active"><div class="reel-message">No public talent to display at the moment.</div></div>';
        this.nextButton.style.display = 'none';
        this.prevButton.style.display = 'none';
    },

    showErrorMessage: function() {
        this.viewer.innerHTML = '<div class="reel-item active"><div class="reel-message">Could not load the feed. Please try again later.</div></div>';
        this.nextButton.style.display = 'none';
        this.prevButton.style.display = 'none';
    }
};
