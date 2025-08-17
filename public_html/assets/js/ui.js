const UI = {
    // Shared properties
    reels: [],
    currentReelIndex: 0,
    viewer: null,
    nextButton: null,
    prevButton: null,

    // --- Public Explore Feed ---

    initExploreFeed: async function() {
        this.viewer = document.getElementById('reel-viewer');
        this.nextButton = document.getElementById('next-reel');
        this.prevButton = document.getElementById('prev-reel');

        if (!this.viewer || !this.nextButton || !this.prevButton) return;

        this.nextButton.addEventListener('click', () => this.showNextReel(this.renderExploreReel.bind(this)));
        this.prevButton.addEventListener('click', () => this.showPrevReel(this.renderExploreReel.bind(this)));

        try {
            this.reels = await Http.get('/api/public/feed.php');
            if (this.reels.length > 0) {
                this.renderExploreReel();
            } else {
                this.showEmptyMessage("No public talent to display at the moment.");
            }
        } catch (error) {
            this.showErrorMessage();
        }
    },

    renderExploreReel: function() {
        const reel = this.reels[this.currentReelIndex];
        this.viewer.innerHTML = '';
        const reelItem = this.createReelItem(reel);
        this.viewer.appendChild(reelItem);
        this.updateNavButtons();
    },

    // --- Authenticated Client Feed ---

    shortlist: [],
    shortlistContainer: null,

    initClientFeed: async function() {
        this.viewer = document.getElementById('reel-viewer');
        this.nextButton = document.getElementById('next-reel');
        this.prevButton = document.getElementById('prev-reel');
        this.shortlistContainer = document.getElementById('shortlist-items');

        if (!this.viewer || !this.nextButton || !this.prevButton || !this.shortlistContainer) return;

        this.nextButton.addEventListener('click', () => this.showNextReel(this.renderClientReel.bind(this)));
        this.prevButton.addEventListener('click', () => this.showPrevReel(this.renderClientReel.bind(this)));

        try {
            this.reels = await Http.get('/api/client/feed.php');
            if (this.reels.length > 0) {
                this.renderClientReel();
            } else {
                this.showEmptyMessage("No new talent in your feed.");
            }
        } catch (error) {
            this.showErrorMessage();
        }
    },

    renderClientReel: function() {
        const reel = this.reels[this.currentReelIndex];
        this.viewer.innerHTML = '';
        const reelItem = this.createReelItem(reel);

        // Add client-specific controls (More menu, shortlist button)
        const moreButton = document.createElement('button');
        moreButton.className = 'reel-more-button';
        moreButton.innerHTML = '•••';

        const shortlistButton = document.createElement('button');
        shortlistButton.innerHTML = 'Add to Shortlist';
        shortlistButton.onclick = () => this.addToShortlist(reel);

        const menu = document.createElement('div');
        menu.className = 'reel-more-menu';
        menu.appendChild(shortlistButton);

        moreButton.onclick = () => menu.classList.toggle('active');

        reelItem.appendChild(moreButton);
        reelItem.appendChild(menu);
        this.viewer.appendChild(reelItem);
        this.updateNavButtons();
    },

    addToShortlist: function(talent) {
        // Avoid adding duplicates
        if (!this.shortlist.find(item => item.talent_user_id === talent.talent_user_id)) {
            this.shortlist.push(talent);
            this.renderShortlist();
        }
        // Close the menu
        document.querySelector('.reel-more-menu.active')?.classList.remove('active');
    },

    renderShortlist: function() {
        this.shortlistContainer.innerHTML = ''; // Clear list
        if (this.shortlist.length === 0) {
            this.shortlistContainer.innerHTML = '<li class="empty-shortlist">Your shortlist is empty.</li>';
        } else {
            this.shortlist.forEach(talent => {
                const li = document.createElement('li');
                li.textContent = `${talent.first_name} ${talent.last_name}`;
                this.shortlistContainer.appendChild(li);
            });
        }
    },

    // --- Shared Helper Functions ---

    createReelItem: function(reel) {
        const reelItem = document.createElement('div');
        reelItem.className = 'reel-item active';

        let mediaElement;
        if (reel.media_type === 'video') {
            mediaElement = document.createElement('video');
            mediaElement.src = '/' + reel.file_path;
            mediaElement.autoplay = true;
            mediaElement.muted = true;
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
        return reelItem;
    },

    showNextReel: function(renderFunc) {
        if (this.currentReelIndex < this.reels.length - 1) {
            this.currentReelIndex++;
            renderFunc();
        }
    },

    showPrevReel: function(renderFunc) {
        if (this.currentReelIndex > 0) {
            this.currentReelIndex--;
            renderFunc();
        }
    },

    updateNavButtons: function() {
        this.prevButton.disabled = this.currentReelIndex === 0;
        this.nextButton.disabled = this.currentReelIndex === this.reels.length - 1;
    },

    showEmptyMessage: function(message) {
        this.viewer.innerHTML = `<div class="reel-item active"><div class="reel-message">${message}</div></div>`;
        this.nextButton.style.display = 'none';
        this.prevButton.style.display = 'none';
    },

    showErrorMessage: function() {
        this.viewer.innerHTML = '<div class="reel-item active"><div class="reel-message">Could not load the feed. Please try again later.</div></div>';
        this.nextButton.style.display = 'none';
        this.prevButton.style.display = 'none';
    }
};
