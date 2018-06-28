var Imtech = {};
Imtech.Pager = function() {

	// Парметры по умолчанию 
    this.paragraphsPerPage = 5; 						// Количество элементов на странице
    this.currentPage = 1;								// Страница, которая открыается при инициализации
    this.pagingControlsContainer = "#pagingControls"; 	// Контейнер для ванигации 
    this.pagingContainerPath = "#text";				// Контейнер c содержанием
    
	// Подсчет общего количества страниц
    this.numPages = function() {
        var numPages = 0;
        if (this.paragraphs != null && this.paragraphsPerPage != null) {
            numPages = Math.ceil(this.paragraphs.length / this.paragraphsPerPage);
        }
        
        return numPages;
    };
    
	// Выводим страницу. 
	// Аргументы:
	// 	page - номер страницы, которую нужно вывести
    this.showPage = function(page) {
        this.currentPage = page;
        var html = "";
		// Формируем содержание текущей страницы
        for (var i = (page-1)*this.paragraphsPerPage; i < ((page-1)*this.paragraphsPerPage) + this.paragraphsPerPage; i++) {
            if (i < this.paragraphs.length) {
                var elem = this.paragraphs.get(i);
                html += "<" + elem.tagName + ">" + elem.innerHTML + "</" + elem.tagName + ">";
            }
        }
        
		// Включаем сформированное содержание в структуру DOM
        jQuery(this.pagingContainerPath).html(html);
        
		// Обновляем навигацию
        renderControls(this.pagingControlsContainer, this.currentPage, this.numPages());
    }
    
	// Обновляем навигацю.
	// Аргументы:
	//  container - контейнер для содержания текущей страницы;
	//  currentPage - номер текущей страницы;
	//  numPages - общее колчисетво страниц.
    var renderControls = function(container, currentPage, numPages) {
		// Формируем разметку навигации
        var pagingControls = "Сторінка: <ul>";
        for (var i = 1; i <= numPages; i++) {
            if (i != currentPage) {
                pagingControls += "<li class='pager'><a href='#' onclick='pager.showPage(" + i + ");  return false; '>" + i + "</a></li>";
            } else {
                pagingControls += '<li class="active">' + i + "</li>";
            }
        }
        
        pagingControls += "</ul>";
        jQuery('body,html').animate({scrollTop: 0}, 1000);
		// Вставляем разметку навигации в DOM
        jQuery(container).html(pagingControls);
    }
}