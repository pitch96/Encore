//
//  CartViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 28/12/22.
//

import UIKit

class CartViewController: UIViewController {
    // MARK: @IBOutlets--
    @IBOutlet weak var emptyCartLbl: UILabel!
    @IBOutlet weak var ticketDataTableView: UITableView!
    
    
    
    // MARK: Variable initializer--
    var cartData : CartModelData?
    lazy var cartViewModel:CartViewModel = {
        var cartViewModel = CartViewModel()
        return cartViewModel
    }()
    var ticketCount: Int?
    // MARK: View DidLoad--
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view.
        ticketDataTableView.delegate = self
        ticketDataTableView.dataSource = self
        
    }
    // MARK: CheckOut APi call--
    override func viewWillAppear(_ animated: Bool) {
        CheckOutApiCall()
    }
    // MARK: PlaceOrder Api Call--
    @IBAction func placeOrderActionButton(_ sender: UIButton) {
        let vc = self.storyboard?.instantiateViewController(withIdentifier: PaymentCheckoutViewController.identifier) as! PaymentCheckoutViewController
        vc.cartData = cartData
        self.navigationController?.pushViewController(vc, animated: false)
    }
    // MARK: Function for Increase Button Action
    /// Create Function For increase the value and show in label
    /// - Parameter sender: UIButton
    /// return : nil
    @objc func tapIncreaseBtn(sender: UIButton){
        if (ticketCount ?? 0) < (cartData?.data?.cartDatas?.first?.ticket?.quantity ?? 0){
            ticketCount = (ticketCount ?? 0) + 1
            self.ticketDataTableView.reloadData()
        }
        
    }
    // MARK: Function for Decrease Button Action
    /// Create Function For decrease the value and show in label
    /// - Parameter sender: UIButton
    /// return : nil
    @objc func tapDecreaseBtn(sender: UIButton){
        if (ticketCount ?? 0) > 1{
            ticketCount = (ticketCount ?? 0) - 1
            self.ticketDataTableView.reloadData()
        }
        
    }
    // MARK: Button action Delete Cart APi Call--
    /// Create Function For buy Delete Cart
    /// - Parameter sender: UIButton
    /// return :nil
    @objc func deleteCartItem(sender: UIButton){
        cartViewModel.callDeleteCartApi(id: cartData?.data?.cartDatas?.first?.id ?? 0) { deleteCartData, IsSuccess in
            if IsSuccess == true{
                self.showSimpleAlert(message: deleteCartData?.message ?? DefaultValue.emptyString.rawValue)
                self.CheckOutApiCall()

            }else{
                
            }
        }
//
    }
}
// MARK: Create extension for tableview--
///show the required detail in tableview
extension CartViewController : UITableViewDelegate, UITableViewDataSource{
    func numberOfSections(in tableView: UITableView) -> Int {
        return 2
    }
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        if section == 0{
            if (cartData?.data?.cartDatas?.count ?? 0 == 0){
                return 1
            }else{
                return cartData?.data?.cartDatas?.count ?? 0
            }
            
        }else{
            return 1
        }
        
    }
    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        if indexPath.section == 0{
            if (cartData?.data?.cartDatas?.count ?? 0 == 0){
                let cell = tableView.dequeueReusableCell(withIdentifier: EmptyCartTVC.identifier, for: indexPath)as!
                EmptyCartTVC
                return cell
            }else{
                let cell = tableView.dequeueReusableCell(withIdentifier: CartTableViewCell.identifier, for: indexPath)as!
                CartTableViewCell
                cell.eventTitle.text = cartData?.data?.cartDatas?.first?.ticket?.event?.eventTitle ?? ""
                cell.ticketTitle.text = cartData?.data?.cartDatas?.first?.ticket?.ticketTitle ?? ""
                cell.lblUnitPrice.text = "$\(cartData?.data?.cartDatas?.first?.ticket?.price ?? 0)"
                //            cell.lblShowQuantity.text = "\(cartData?.data?.cartDatas?.first?.quantity)"
                cell.lblShowQuantity.text = "\(ticketCount ?? 0)"
                cell.lblAmmount.text = "$\((ticketCount ?? 0) * (cartData?.data?.cartDatas?.first?.ticket?.price ?? 0))"
                cell.decreaseButton.tag = indexPath.row
                cell.increaseButton.tag = indexPath.row
                cell.increaseButton.addTarget(self, action: #selector(tapIncreaseBtn(sender: )), for: .touchUpInside)
                cell.decreaseButton.addTarget(self, action: #selector(tapDecreaseBtn(sender: )), for: .touchUpInside)
                cell.deleteButton.addTarget(self, action: #selector(deleteCartItem(sender: )), for: .touchUpInside)
                if let imageURL = cartData?.data?.cartDatas?.first?.ticket?.event?.image{
                    let urlString = imageURL.addingPercentEncoding(withAllowedCharacters: .urlQueryAllowed) ?? DefaultValue.emptyString.rawValue
                    cell.eventImage.sd_setImage(with: URL(string: urlString)) { reqimage,err,_,url  in
                    }
                }else{
                    //cell.bannerImage.image =
                }
                return cell
            }
        
        }else {
            let cell = tableView.dequeueReusableCell(withIdentifier: OrderDetailTableViewCell.identifier, for: indexPath)as! OrderDetailTableViewCell
            cell.lblPrice.text = "$\(cartData?.data?.cartDatas?.first?.ticket?.price ?? 0)"
            //            cell.lblDiscount
            cell.totalPrice.text = "$\((ticketCount ?? 0) * (cartData?.data?.cartDatas?.first?.ticket?.price ?? 0))"
            return cell
            
        }
        
        
    }
}
// MARK: Extension for CartViewController--
//Create function for calling Checkout api call
extension CartViewController{
    func CheckOutApiCall(){
        cartViewModel.callCheckOutApi{ [weak self]cartDetails, isSuccess in
            if isSuccess == true{
                self?.cartData = cartDetails
                self?.ticketCount = cartDetails.data?.cartDatas?.first?.quantity ?? 0
                self?.ticketDataTableView.reloadData()
            }
        }
    }
}
