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

function updateCourses(sel, coursesOutputBox){
  var selection: string[] = getSelectedOptions(sel);
  var output: string = "";

  for (var i: number = 0; i < selection.length; i++){
    output += "<option value=\" " + selection[i] + "\">" + selection[i] + "</option>";
  }
  coursesOutputBox.innerHTML = output;
}
