<style>
    .bokun-import-running {
        display: inline-flex !important;
        align-items: center;
        gap: .45rem;
    }

    .bokun-import-running svg {
        display: none;
    }

    .bokun-import-running::before {
        content: '';
        width: 1rem;
        height: 1rem;
        flex: 0 0 1rem;
        border: 2px solid rgba(13, 110, 253, .25);
        border-top-color: #0d6efd;
        border-radius: 50%;
        animation: bokun-command-spinner .75s linear infinite;
    }

    .bokun-import-message {
        max-width: min(700px, 80vw);
        white-space: normal !important;
        cursor: default;
        opacity: 1 !important;
    }

    @keyframes bokun-command-spinner {
        to { transform: rotate(360deg); }
    }
</style>
