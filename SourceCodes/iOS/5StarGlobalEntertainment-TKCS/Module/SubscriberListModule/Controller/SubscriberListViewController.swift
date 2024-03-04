//
//  SubscriberListViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 02/03/23.
//

import UIKit

class SubscriberListViewController: UIViewController {
// MARK: IBOutlets--
    @IBOutlet weak var subscriberTableView: UITableView!
    @IBOutlet weak var searchTextField: UITextField!
    @IBOutlet weak var lblNoRecord: UILabel!
    
    // MARK: variable initializer--
    var subscribeDetailModel = SubscriberListModel()
    lazy var subscriberListViewModel:SubscriberListViewModel = {
        var subscriberListViewModel = SubscriberListViewModel()
        return subscriberListViewModel
    }()
    var manageSubscriberData: [SubscriberData]?
    var searchSubscriberData: [SubscriberData]?
    // MARK: vieDidLoad--
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view.
        subscriberTableView.delegate = self
        subscriberTableView.dataSource = self
        searchTextField.delegate = self
        lblNoRecord.isHidden = true
        SubcriberListApi()
    }
    // MARK: Create func for calling subscriber list Api call-
    func SubcriberListApi(){
        subscriberListViewModel.callSubscriberListApi {[weak self] subscribeList, isSuccess in
            if isSuccess == true{
                self?.manageSubscriberData = subscribeList.data?.reversed()
                self?.searchSubscriberData = subscribeList.data
                self?.subscriberTableView.reloadData()
            }else{
                self?.showSimpleAlert(message: subscribeList.message ?? DefaultValue.errorMsg.rawValue)
            }
        }
    }
    
    // MARK: Back Button Action--
    /// Create Action for navigate to previous Screen
    /// - Parameter sender : UIButton
    @IBAction func backButtonAction(_ sender: UIButton) {
        self.navigationController?.popViewController(animated: true)
    }
    

}
// MARK: Extension for tableview delegate--
extension SubscriberListViewController: UITableViewDelegate, UITableViewDataSource {
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        if searchSubscriberData?.count == 0{
            lblNoRecord.isHidden = false
        }else{
            lblNoRecord.isHidden = true
        }
        return searchSubscriberData?.count ?? 0
    }
    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCell(withIdentifier: SubscriberListTableViewCell.identifier)as! SubscriberListTableViewCell
        let data = searchSubscriberData?[indexPath.row]
        cell.lblSubscriber.text = data?.email
        return cell
    }    
    
}
// MARK: Extention for TextFiled Delegate--
///create function for seach data on basis of text--
extension SubscriberListViewController: UITextFieldDelegate{
    func textField(_ textField: UITextField, shouldChangeCharactersIn range: NSRange, replacementString string: String) -> Bool {
        if let searchedText = searchTextField.text,
           let textRange = Range(range, in: searchedText){
            let updatedText = searchedText.replacingCharacters(in: textRange, with: string)
            if updatedText != ""{
                searchSubscriberData = manageSubscriberData?.filter({ values in
                    return (values.email ?? DefaultValue.emptyString.rawValue).lowercased().contains(updatedText.lowercased())
                })
            }else{
                searchSubscriberData = manageSubscriberData
            }
            subscriberTableView.reloadData()
        }
        return true

    }
    func textFieldShouldReturn(_ textField: UITextField) -> Bool {
        searchTextField.returnKeyType = UIReturnKeyType.search
        searchTextField.returnKeyType = UIReturnKeyType.done
        return true
    }
}
