

// plugins/localStoragePlugin.js
export const localStoragePlugin = store => {
    // Called when the store is initialized
    store.subscribe((mutation, state) => {
        // Save the entire state to localStorage
        localStorage.setItem('store', JSON.stringify(state));
    });
};

  // Helper function to load the state from localStorage
export const loadState = () => {
    const savedState = localStorage.getItem('store');
    if (savedState) {
        return JSON.parse(savedState);
    }
    return {};
};
