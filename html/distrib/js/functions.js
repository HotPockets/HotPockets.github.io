var outputList = "";
var list = [];
var _totalCredits;
var _yVal;
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
function createPDF(doc, majorArr, evalName) {
    _yVal = 56;
    var major = null;
    writeHeading(doc);
    for (var i = 0; i < majorArr.length; i++) {
        writeMajor(doc, majorArr[i]);
    }
    doc.save(evalName + '.pdf');
}
function writeHeading(doc) {
    doc.setTextColor(100);
    doc.setFont("helvetica");
    doc.setFontType("bold");
    doc.setFontSize(36);
    doc.setTextColor(255, 0, 0);
    doc.text(65, 30, 'Marist College');
    doc.setFontSize(28);
    doc.setTextColor(0, 0, 0);
    doc.text(38, 40, 'Unofficial Transfer Evaluation');
}
function writeMajor(doc, major) {
    var xLeftCol = 25;
    var xCreditCol = 170;
    var rectWidth = 163;
    var yTopRightCorner;
    var yTableTop;
    _totalCredits = 0;
    doc.setFontSize(22);
    if (major.isMinor) {
        doc.text(xLeftCol, _yVal, "Minor in " + major.name);
    }
    else if (major.name === "No Major") {
        doc.text(xLeftCol, _yVal, "All Transferable Courses");
    }
    else {
        doc.text(xLeftCol, _yVal, "Major in " + major.name);
    }
    _yVal += 10;
    yTableTop = _yVal - 7;
    doc.rect(xLeftCol - 1, yTableTop, rectWidth, 9);
    doc.setDrawColor(0);
    doc.setFillColor(255, 0, 0);
    doc.rect(xLeftCol - 1, yTableTop, rectWidth, 9, 'FD');
    doc.setFontSize(20);
    doc.text(xLeftCol, _yVal, "Marist Course");
    doc.text(xCreditCol - 10, _yVal, "Credits");
    yTopRightCorner = _yVal + 2;
    _yVal += 8;
    doc.setFontType("normal");
    doc.setFontSize(16);
    for (var i = 0; i < major.courses.length; i++) {
        var credits = major.courses[i].getCredits();
        doc.text(xLeftCol, _yVal, major.courses[i].subject + " " + major.courses[i].courseNum + ": " + major.courses[i].courseTitle);
        doc.text(xCreditCol, _yVal, "" + credits);
        _totalCredits += credits;
        _yVal += 7;
    }
    doc.rect(xLeftCol - 1, yTopRightCorner, rectWidth, (_yVal - 3) - yTopRightCorner);
    doc.line(xCreditCol - 13, yTableTop, xCreditCol - 13, _yVal - 3);
    _yVal += 4;
    doc.setFontSize(20);
    doc.setFontType("bold");
    doc.text(xCreditCol - 34, _yVal, "Total:");
    if (_totalCredits > 9) {
        doc.text(xCreditCol - 2, _yVal, "" + _totalCredits);
    }
    else {
        doc.text(xCreditCol, _yVal, "" + _totalCredits);
    }
    _yVal += 8;
}
var TransferCourse = (function () {
    function TransferCourse(subject, courseNum, courseTitle) {
        this.subject = subject;
        this.courseNum = courseNum;
        this.courseTitle = courseTitle;
        this.init();
    }
    TransferCourse.prototype.init = function () {
        this.credits = 0;
    };
    TransferCourse.prototype.setCredits = function (credits) {
        this.credits = credits;
    };
    TransferCourse.prototype.getCredits = function () {
        return this.credits;
    };
    TransferCourse.prototype.toString = function () {
        return this.subject + " " + this.courseNum + ": " + this.courseTitle;
    };
    return TransferCourse;
})();
var Major = (function () {
    function Major(name) {
        this.name = name;
        this.init();
    }
    Major.prototype.init = function () {
        this.courses = [];
        this.isMinor = false;
    };
    Major.prototype.addCourse = function (course) {
        this.courses.push(course);
    };
    Major.prototype.setMinor = function () {
        this.isMinor = true;
    };
    return Major;
})();
