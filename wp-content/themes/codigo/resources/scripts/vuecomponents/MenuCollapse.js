
export default {
  data() {
    return {
      search: '',
      isLoading: false,
      searchResults: [],
      noResults: false,
      menuCollapse: false,
      searchCollapse: false
    }
  },
  computed: {
    isSearchDisabled() {
      return this.search.trim().length < 3;
    },
  },
  methods: {
    toggleMenu() {
      document.querySelector('body').classList.toggle('overflow-hidden');
      this.menuCollapse = !this.menuCollapse;

      if (this.menuCollapse) {
        this.searchCollapse = false;
        this.searchResults = [];
        this.search = '';
        this.noResults = false;
      }
    },
    toggleSearch() {
      this.toggleMenu();
      this.searchCollapse = true;
    },
    handleSearch() {
      if (typeof ajaxObject === 'undefined') {
        return;
      }

      this.isLoading = true;

      fetch(ajaxObject.ajaxurl + '?action=search_posts&search=' + this.search, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
          'X-WP-Nonce': ajaxObject.nonce,
        },
      }).then(response => response.json())
        .then(data => {
          if (data?.data.length === 0) {
            this.noResults = true;
            this.searchResults = [];
            return;
          }

          this.searchResults = data?.data;
        })
        .catch(error => console.error(error))
        .finally(() => {
          this.isLoading = false;
        });
    }
  }
}

