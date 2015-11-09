function getSelectedOptions(sel) {
    var opts = [], opt;
    for (var i = 0, len = sel.options.length; i < len; i++) {
        opt = sel.options[i];
        if (opt.selected) {
            opts.push(opt.innerHTML);
        }
    }
    return opts;
}
function updateCourses(sel, coursesOutputBox) {
    var selection = getSelectedOptions(sel);
    var output = "";
    for (var i = 0; i < selection.length; i++) {
        output += "<option value=\" " + selection[i] + "\">" + selection[i] + "</option>";
    }
    coursesOutputBox.innerHTML = output;
}
