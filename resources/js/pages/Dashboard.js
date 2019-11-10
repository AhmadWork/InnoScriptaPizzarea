import React, { Component } from 'react';
import { connect } from 'react-redux';
import Http from '../Http';

class Dashboard extends Component {
  constructor(props) {
    super(props);

    // Initial state.
    this.state = {
      order: null,
      error: false,
      data: [],
    };

    // API endpoint.
    this.api = '/api/order';
  }

  componentDidMount() {
    const token = localStorage.getItem('access_token');
    console.log(token);
    Http.get(`${this.api}`)
      .then((response) => {
        const { data } = response.data;
        this.setState({
          data, error: false,
        });
      })
      .catch(() => {
        this.setState({
          error: 'Unable to fetch data.',
        });
      });
  }

  handleChange = (e) => {
    const { name, value } = e.target;
    this.setState({ [name]: value });
  }

  handleSubmit = (e) => {
    e.preventDefault();
    const { order } = this.state;
    this.addOrder(order);
  }

  addOrder = (order) => {
    Http.post(this.api, { value: order })
      .then(({ data }) => {
        const newItem = {
          id: data.id,
          value: order,
        };
        const allOrders = [newItem, ...this.state.data];
        this.setState({ data: allOrders, order: null });
        this.orderForm.reset();
      })
      .catch(() => {
        this.setState({
          error: 'Sorry, there was an error saving your to do.',
        });
      });
  }

  closeOrder = (e) => {
    const { key } = e.target.dataset;
    const { data: orders } = this.state;

    Http.patch(`${this.api}/${key}`, { status: 'deliverd' })
      .then(() => {
        const updatedOrders = orders.filter(order => order.id !== parseInt(key, 10));
        this.setState({ data: updatedOrders });
      })
      .catch(() => {
        this.setState({
          error: 'Sorry, there was an error closing your to do.',
        });
      });
  }

  render() {
    const {
      data, error,
    } = this.state;

    return (
      <div className="container py-5">

        <div className="add-orders mb-5">
          <h1 className="text-center mb-4">Add a To Do</h1>
          <form method="post" onSubmit={this.handleSubmit} ref={(el) => { this.orderForm = el; }}>
            <div className="form-group">
              <label htmlFor="addOrder">Add a New To Do</label>
              <div className="d-flex">
                <input
                  id="addOrder"
                  name="order"
                  className="form-control mr-3"
                  placeholder="Build a To Do app..."
                  onChange={this.handleChange}
                />
                <button type="submit" className="btn btn-primary">Add</button>
              </div>
            </div>
          </form>
        </div>

        {error &&
        <div className="alert alert-warning" role="alert">
          {error}
        </div>
        }

        <div className="orders">
          <h1 className="text-center mb-4">Open To Dos</h1>
          <table className="table table-striped">
            <tbody>
              <tr><th>To Do</th><th>Action</th></tr>
              {data.map(order => (
                <tr key={order.id}>
                  <td>{order.value}</td>
                  <td>
                    <button
                      type="button"
                      className="btn btn-secondary"
                      onClick={this.closeOrder}
                      data-key={order.id}
                    >
                    Close
                    </button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>

        </div>
      </div>
    );
  }
}

const mapStateToProps = state => ({
  isAuthenticated: state.Auth.isAuthenticated,
  user: state.Auth.user,
});

export default connect(mapStateToProps)(Dashboard);
