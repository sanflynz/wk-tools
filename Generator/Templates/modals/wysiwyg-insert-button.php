<div id="wysiwyg-insert-button" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Insert link</h4>
      </div>
      <div class="modal-body">
        <table class="wysiwyg-modal">
          <tr>
            <td>Text</td>
            <td>
              <input id="insert-button-text" class="form-control" value="">
            </td>
          </tr><tr>
            <td>URL</td>
            <td>
              <input id="insert-button-url" class="form-control" value="">
            </td>
          </tr>
          <tr>
            <td>Target</td>
            <td>
              <select id="insert-button-target" class="form-control">
                <option value="">Parent</option>
                <option value="_blank">New tab</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>Type</td>
            <td>
              <select id="insert-button-type" class="form-control">
                <option value="">Plain link</option>
                <option value="btn-primary">Primary button</option>
                <option value="btn-featured">Featured button (red)</option>
                <option value="btn-commerce">Commerce button (green)</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>Size</td>
            <td>
              <select id="insert-button-size" class="form-control">
                <option value="">Normal</option>
                <option value=" btn-mini">Mini</option>
                <option value=" btn-small">Small</option>
                <option value=" btn-large">Large</option>
              </select>
            </td>
          </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" id="insert-button-action" class="btn btn-success">Insert button</button>
      </div>
    </div>

  </div>
</div>