var outputList:string = "";
var list: TransferCourse[] = [];

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


class TransferCourse {

  constructor(public subject: string,
              public courseNum: string,
              public courseTitle: string) {
          this.init();
        }

        public init(): void {

        }

        public toString(): string {
          return this.subject + " " + this.courseNum + ": " + this.courseTitle;
        }

}
