var outputList:string = "";
var list: TransferCourse[] = [];
var _totalCredits: number;
var _yVal: number;

/*
if (localStorage.getItem("outputList") !== null){
  outputList = localStorage.getItem("outputList");
}
*/

function getSelectedOptions(sel) {
    var opts = [], opt;

    // loop through options in select list
    for (var i=0, len=sel.options.length; i<len; i++) {
        opt = sel.options[i];

        // check if selected
        if ( opt.selected ) {
            // add to array of option elements to return from this function
            opts.push(opt.innerHTML);
        }
    }

    // return array containing references to selected option elements
    return opts;
}

function removeSelectedOptions(sel) {
    var opts = [], opt;

    // loop through options in select list
    for (var i=0, len=sel.options.length; i<len; i++) {
        opt = sel.options[i];

        // check if selected
        if ( opt.selected ) {
          opts.push(opt.innerHTML);
        }
    }

    for (var i=0; i < opts.length; i++){
      sel.remove(opts[i]);
    }
    outputList = sel.innerHTML;
    //localStorage.setItem("outputList", outputList);
}

function updateCourses(sub, sel, coursesOutputBox){
  var selection: string[] = getSelectedOptions(sel);
  var output: string = "";
  console.log("The Sub is: " + sub);

  for (var i: number = 0; i < selection.length; i++){
    var str = selection[i].replace(/\s-\s/g, "-");
    var arr = str.split("-");
    var courseNum = arr[0];
    var courseTitle = arr[1];
    var course = new TransferCourse(sub, courseNum, courseTitle);
    //Check to see if course is there already
    var found = false;
    for (var j = 0; j < list.length; j++){
      if(list[j].subject === sub && list[j].courseNum === courseNum){
        found = true;
        break;
      }
    }
    if (!found){
      list.push(course);
      output += "<option value=\" " + selection[i] + "\">" + sub + " " + selection[i] + "</option>";
    } else {
      console.log("Tried to add " + courseTitle + " again. DENIED.");
    }
  }
  outputList = outputList + output;
  //localStorage.setItem("outputList", outputList);
  coursesOutputBox.innerHTML = outputList;

  for(var i = 0; i < list.length; i++){
    console.log(list[i].toString());
  }

}

function populateList(element, text: string){
  element.innerHTML = text;
}
//---------------------------------------------------------
function createPDF(doc){
  _yVal = 56;
  var major = testMajor();

  writeHeading(doc);

  for (var i = 0; i < 3; i++){
    writeMajor(doc, major);
  }

  doc.save('Test.pdf');
}

function writeHeading(doc){
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

function writeMajor(doc, major: Major){
  var xLeftCol = 25;
  var xCreditCol = 170;
  var rectWidth = 163;
  var yTopRightCorner;
  var yTableTop;

  _totalCredits = 0;

  //Major Heading
  doc.setFontSize(22);
  doc.text(xLeftCol, _yVal, major.name);
  _yVal += 10;

  //Table Header
  doc.setFontSize(20);
  doc.text(xLeftCol, _yVal, "Course");
  doc.text(xCreditCol -10, _yVal, "Credits");
  yTableTop = _yVal - 7;
  doc.rect(xLeftCol - 1, yTableTop, rectWidth, 9);
  yTopRightCorner = _yVal + 2;
  _yVal += 8;

  //Table Body
  doc.setFontType("normal");
  doc.setFontSize(16);
  for(var i = 0; i < major.courses.length; i++){
    var credits = major.courses[i].getCredits();
    doc.text(xLeftCol, _yVal, major.courses[i].subject + " " + major.courses[i].courseNum + ": " + major.courses[i].courseTitle);
    doc.text(xCreditCol, _yVal, "" + credits);
    _totalCredits += credits;
    _yVal += 7;
  }
  doc.rect(xLeftCol - 1, yTopRightCorner, rectWidth, (_yVal - 3) - yTopRightCorner);
  doc.line(xCreditCol - 13, yTableTop, xCreditCol - 13, _yVal - 3)
  //Table Footer
  _yVal += 4;
  doc.setFontSize(20);
  doc.setFontType("bold");
  doc.text(xCreditCol - 34, _yVal, "Total:");
  doc.text(xCreditCol - 2, _yVal, "" + _totalCredits);

  //End
  _yVal += 8;

}

function testMajor(): Major{
  var majorName = "The Major Name";
  var courseTitle = "Title Of Transfer Course ";
  var courseNum = "40";
  var subject = "SUB";
  var course;
  var numberOfCourses = 3;

  var major = new Major(majorName);
  for(var i = 0; i < numberOfCourses; i++){
    course = new TransferCourse(subject, courseNum + i, courseTitle + i);
    course.setCredits(4);
    major.addCourse(course);
  }

  return major;
}
//---------------------------------------------------------

class TransferCourse {
  private credits: number;
  constructor(public subject: string,
              public courseNum: string,
              public courseTitle: string) {
          this.init();
        }

        public init(): void {
          this.credits = 0;
        }

        public setCredits(credits){
          this.credits = credits;
        }

        public getCredits(): number{
          return this.credits;
        }

        public toString(): string {
          return this.subject + " " + this.courseNum + ": " + this.courseTitle;
        }

}

class Major {
  public courses: TransferCourse[];
  public isMinor: boolean;

  constructor(public name: string) {
          this.init();
        }

        public init(): void {
          this.courses = [];
          this.isMinor= false;
        }

        public addCourse(course: TransferCourse): void{
          this.courses.push(course);
        }

        public setMinor(){
          this.isMinor = true;
        }
}
