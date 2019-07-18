class AppController {
  complete_flag = 0;
  uncomplete_flag = 0;
  constructor() {
    this.model = new AppModel();
    this.render();
  }

  addTodo(caption, isCompleted) {
    this.model.addTodo(caption, isCompleted);
    this.render();
  }

  attachEventHandlers() {
    var self = this;
    $("#addtodo")
      .off()
      .click(function(e) {
        var input = $("#caption").val();
        self.addTodo(input, false);
      });

    $("#completed")
      .off()
      .click(function(e) {
        if (self.complete_flag == 0) {
          self.model.get_database_data("completed");
          self.complete_flag = 1;
        } else if (self.complete_flag == 1) {
          self.model.get_database_data("all");
          self.complete_flag = 0;
        }
        self.render();
      });

    $("#uncompleted")
      .off()
      .click(function(e) {
        if (self.uncomplete_flag == 0) {
          self.model.get_database_data("uncompleted");
          self.uncomplete_flag = 1;
        } else if (self.uncomplete_flag == 1) {
          self.model.get_database_data("all");
          self.uncomplete_flag = 0;
        }
        self.render();
      });

    $("#remove_filter")
      .off()
      .click(function(e) {
        self.model.get_database_data("all");
      });
  }

  render() {
    var self = this;

    var list = $("#list").html("");

    for (var i in this.model.todoCollection) {
      var todoItem = this.model.todoCollection[i];
      var indexnew = this.model.todoCollection[i]["index"];
      console.log(indexnew);
      var li = $("<li></li>");
      li.text(todoItem.caption);

      var doneBtn = $("<input type='checkbox'>")
        .off()
        .click(
          function(todoItem, i, indexnew) {
            self.model.toggleTodo(indexnew, todoItem);
          }.bind(null, todoItem, li, indexnew)
        );

      var deleteBtn = $("<input type='button'>")
        .off()
        .click(
          function(indexnwew, i) {
            console.log(indexnew);
            self.model.removeTodo(indexnew, i);
            self.render();
          }.bind(null, indexnew, i)
        );

      deleteBtn.val("remove");
      li.off().dblclick(
        function(li, todoItem, indexnew) {
          var inputnew = $("<input type='text'>");
          li.text("");
          li.prepend(inputnew);
          inputnew.dblclick(
            function(li, inputnew, todoItem, indexnew) {
              self.model.editTodo(indexnew, inputnew.val(), todoItem);
              self.render();
            }.bind(null, li, inputnew, todoItem, indexnew)
          );
        }.bind(null, li, todoItem, indexnew)
      );

      if (todoItem.isCompleted) {
        doneBtn.prop("checked", true);
        li.css("text-decoration", "line-through");
      } else {
        doneBtn.prop("checked", false);
        li.css("text-decoration", "line");
      }

      li.append(doneBtn);
      li.append(deleteBtn);
      list.append(li);
    }
    this.attachEventHandlers();
  }
}
