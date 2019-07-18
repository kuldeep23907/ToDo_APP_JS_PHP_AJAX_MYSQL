class TodoItem {
  constructor(caption, isCompleted, index) {
    this.caption = caption;
    this.isCompleted = isCompleted;
    this.index = index;
  }
  toggle() {
    if (this.isCompleted == false) this.isCompleted = true;
    else if (this.isCompleted == true) this.isCompleted = false;
  }
}

class AppModel {
  input = "";

  constructor(filter) {
    this.todoCollection = [];
    this.get_database_data("all");
  }

  get_database_data(filter) {
    var tt = "server/get.php";
    var self = this;
    this.todoCollection = [];
    $.ajax({
      url: tt,
      k: 0,
      data: { filter: filter },
      success: function(result) {
        for (var k = 0; k < result.length; k++) {
          if (result[k][0].isCompleted == "0") var cvb = false;
          else if (result[k][0].isCompleted == "1") var cvb = true;
          var newItem = new TodoItem(
            result[k][0].caption,
            cvb,
            result[k][0].index
          );
          self.todoCollection.push(newItem);
        }
      }
    });
  }

  addTodo = function(caption, isCompleted) {
    var getUrl = "server/insert.php";
    var self = this;
    $.ajax({
      url: getUrl,
      type: "post",
      data: {
        caption: caption,
        iscompleted: isCompleted
      },
      dataType: "json",
      success: function(result) {
        console.log(result);

        var data_json = JSON.parse(JSON.stringify(result));
        console.log(data_json["data"]);
        self.todoCollection.push(
          new TodoItem(caption, isCompleted, data_json["data"][0].index)
        );
      },

      error: function(result) {
        console.log(result);
      }
    });
  };

  removeTodo(index, i) {
    var self = this;
    console.log("index", index);
    $.post("server/delete.php", { id: index }, function(result) {
      console.log(result["success"]);
      if (result["success"] == true) self.todoCollection.splice(i, 1);
      else if (result["error"] == true) console.log(result);
    });

    console.log(this.todoCollection);
  }

  editTodo(index, caption, todoItem) {
    console.log("index", index);
    $.post("server/edit.php?turn=1", { id: index, caption: caption }, function(
      result
    ) {
      if (result["success"] == true) todoItem.caption = caption;
      else if (result["error"] == true) console.log(result);
    });

    console.log(this.todoCollection);
  }

  toggleTodo(index, todoItem) {
    var self = this;
    console.log(todoItem);

    $.ajax({
      url: "server/edit.php?turn=0",
      dataType: "text",
      type: "post",
      contentType: "application/x-www-form-urlencoded",
      data: { id: index },
      success: function(result) {
        todoItem.toggle();
      },

      error: function(result) {
        console.log(result);
      }
    });

    console.log(this.todoCollection);
  }
}
