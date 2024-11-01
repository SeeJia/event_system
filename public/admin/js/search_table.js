document.getElementById('searchInput').addEventListener('keyup', function() {
    var input = this.value.toLowerCase();
    var rows = Array.from(document.querySelectorAll('.table tbody tr'));

    // 首先将所有行都恢复可见
    rows.forEach(function(row) {
        row.style.display = '';
    });

    // 找到匹配的行
    var matchingRows = rows.filter(function(row) {
        var cells = row.querySelectorAll('td');
        return Array.from(cells).some(function(cell) {
            return cell.textContent.toLowerCase().includes(input);
        });
    });

    // 找到不匹配的行并隐藏
    var nonMatchingRows = rows.filter(function(row) {
        return !matchingRows.includes(row);
    });
    nonMatchingRows.forEach(function(row) {
        row.style.display = 'none';
    });

    // 将匹配的行插入到表格的顶部
    var tbody = document.querySelector('.table tbody');
    matchingRows.forEach(function(row) {
        if (tbody.firstChild !== row) {
            tbody.insertBefore(row, tbody.firstChild);
        }
    });
});