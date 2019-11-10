
import React,{useState} from 'react'
import {useSpring,animated,config} from 'react-spring'
import { Table,Button } from 'reactstrap';
import {useStateValue}from '../Context';
import { Link } from 'react-router-dom';

const Checkout = ({isOpen}) => {
    const [{cart}, dispatch] = useStateValue();

    const {x} = useSpring({
        x: isOpen ? 0:100,
        config:{
           friction:50,
           mass:1,
           delay:3000

        }
      });
    
    return (
        <div className="checkout" style={{pointerEvents:isOpen?'all':'none'}}>
        <animated.div style={{transform:x.interpolate(x=>`translate3d(-${x}%,0,0)`)}} className="checkout-left"> 
        <Table >
        
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
          </tr>
        </thead>     
        <tbody>
        {cart.map(quantity=>(
         
       
              <tr>
                <th scope="row">{quantity.id}</th>
                <td>{quantity.title}</td>
                <td>{quantity.quantity}</td>
                <td>{quantity.price*quantity.quantity}</td>
              </tr>
              
           
        ))}
        </tbody>
        </Table>
        </animated.div>
        <animated.div style={{transform:x.interpolate(x=>`translate3d(${x}%,0,0)`)}}  className="checkout-right">
        <Link to="/checkout"><Button className='checkout_button' onClick >Procced tO checkout</Button></Link>
        </animated.div>
    </div>
      

    )
}

export default Checkout
