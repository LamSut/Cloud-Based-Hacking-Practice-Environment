//Category CTF
function searchByCategory(category) {
    window.location.href = "./view.php?search=" + category;
  }
  
class Category {
  constructor(name, clickHandler) {
    this.name = name;
    this.element = document.createElement('p');
    this.element.textContent = name;
    this.element.addEventListener('click', clickHandler);
  }
  render(container) {
    container.appendChild(this.element);
  }
}

class CategoryBar {
  constructor(containerId) {
    this.container = document.getElementById(containerId);
    this.categories = [];
  }
  addCategory(name, clickHandler) {
    const category = new Category(name, clickHandler);
    this.categories.push(category);
  }
  render() {
    this.categories.forEach(category => category.render(this.container));
  }
}
// Usage:
const categoryBar = new CategoryBar('ctf-navbar');
categoryBar.addCategory('All Challenges', () => searchByCategory(''));
categoryBar.addCategory('Reverse Engineering', () => searchByCategory('Reverse Engineering'));
categoryBar.addCategory('Web Exploitation', () => searchByCategory('Web Exploitation'));
categoryBar.addCategory('Binary Exploitation', () => searchByCategory('Binary Exploitation'));
categoryBar.addCategory('Forensics', () => searchByCategory('Forensics'));
categoryBar.addCategory('Cryptography', () => searchByCategory('Cryptography'));
categoryBar.render();