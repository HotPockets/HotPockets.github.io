var outputList = "";
var list = [];
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
}
function updateCourses(sub, sel, coursesOutputBox) {
    var selection = getSelectedOptions(sel);
    var output = "";
    console.log("The Sub is: " + sub);
    for (var i = 0; i < selection.length; i++) {
        var str = selection[i].replace(/\s-\s/g, "-");
        var arr = str.split("-");
        var courseNum = arr[0];
        var courseTitle = arr[1];
        var course = new TransferCourse(sub, courseNum, courseTitle);
        var found = false;
        for (var j = 0; j < list.length; j++) {
            if (list[j].subject === sub && list[j].courseNum === courseNum) {
                found = true;
                break;
            }
        }
        if (!found) {
            list.push(course);
            output += "<option value=\" " + selection[i] + "\">" + sub + " " + selection[i] + "</option>";
        }
        else {
            console.log("Tried to add " + courseTitle + " again. DENIED.");
        }
    }
    outputList = outputList + output;
    coursesOutputBox.innerHTML = outputList;
    for (var i = 0; i < list.length; i++) {
        console.log(list[i].toString());
    }
}
function populateList(element, text) {
    element.innerHTML = text;
}
var TransferCourse = (function () {
    function TransferCourse(subject, courseNum, courseTitle) {
        this.subject = subject;
        this.courseNum = courseNum;
        this.courseTitle = courseTitle;
        this.init();
    }
    TransferCourse.prototype.init = function () {
    };
    TransferCourse.prototype.toString = function () {
        return this.subject + " " + this.courseNum + ": " + this.courseTitle;
    };
    return TransferCourse;
})();
