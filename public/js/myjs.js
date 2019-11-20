function createElementFromHTML(html_tring) {
    var div = document.createElement('div');
    div.innerHTML = html_tring.trim();
    return div.firstChild; 
}

class InnerManagement{
    constructor(container_id, inner_class_name){
        let container_tag = document.getElementById(container_id);
        this.receiveInnerTags(container_tag, inner_class_name);
    }

    receiveInnerTags(container_tag, inner_class_name){
        this.container_tag = container_tag;
        this.inner_element_array = [];
        let inner_list = container_tag.getElementsByClassName(inner_class_name);
 
        for (let index = 0; index < inner_list.length; index++) {
            this.inner_element_array[inner_list[index].dataset.index] = inner_list[index];
        }
    }

    get inner_elements(){
        return this.inner_element_array;
    }

    get container(){
        return this.container_tag;
    }

    insert(start_point, end_point){
        let index = this.inner_element_array.length;
        let inner_element;
        if(typeof end_point === 'undefined')
        {
            inner_element = createElementFromHTML(start_point);
        }
        else
        {
            inner_element = createElementFromHTML(start_point + index + end_point);
        }
        inner_element.dataset.index = index;
        this.inner_element_array.push(inner_element);
        this.container_tag.append(inner_element);
        return inner_element;
    }
}