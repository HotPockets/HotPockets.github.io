var outputList = "";
if (localStorage.getItem("outputList") !== null) {
    outputList = localStorage.getItem("outputList");
}
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
function removeSelectedOptions(sel) {
    var opts = [], opt;
    for (var i = 0, len = sel.options.length; i < len; i++) {
        opt = sel.options[i];
        if (opt.selected) {
            opts.push(opt.innerHTML);
        }
    }
    for (var i = 0; i < opts.length; i++) {
        sel.remove(opts[i]);
    }
    outputList = sel.innerHTML;
    localStorage.setItem("outputList", outputList);
}
function updateCourses(sel, coursesOutputBox) {
    var selection = getSelectedOptions(sel);
    var output = "";
    for (var i = 0; i < selection.length; i++) {
        output += "<option value=\" " + selection[i] + "\">" + selection[i] + "</option>";
    }
    outputList = outputList + output;
    localStorage.setItem("outputList", outputList);
    coursesOutputBox.innerHTML = outputList;
}
function populateList(element, text) {
    element.innerHTML = text;
}
