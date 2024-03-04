//
//  ManageEventViewController.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 05/01/23.
//

import UIKit

class ManageEventViewController: UIViewController {

    @IBOutlet weak var searchBar: UISearchBar!
    
    @IBOutlet weak var eventSelection: UISegmentedControl!
    @IBOutlet weak var manageEventTableView: UITableView!
    override func viewDidLoad() {
        super.viewDidLoad()
        manageEventTableView.delegate = self
        manageEventTableView.dataSource = self
        // Do any additional setup after loading the view.
    }
    
    @IBAction func switchButtonAction(_ sender: UISwitch) {
        if (sender.isOn == true){
            let alert = UIAlertController(title: "Are you sure?", message: "Are you sure, you want to make live this event?", preferredStyle: UIAlertController.Style.alert)
            alert.addAction(UIAlertAction(title: "Yes", style: UIAlertAction.Style.default, handler:{ action in
            }))
            alert.addAction(UIAlertAction(title: Alert.cancelTitle, style: UIAlertAction.Style.cancel, handler: nil))
            self.present(alert, animated: false, completion: nil)
            }
            else{
                print("off")
            }
        
        
    }
    @IBAction func eventSelectionButtonAction(_ sender: UISegmentedControl) {
        let selection = sender.selectedSegmentIndex
        switch selection {
        case 0:
            manageEventTableView.isHidden = true
        case 1:
            manageEventTableView.isHidden = false
        default:
           print("hello")
        }
    }
    
    @IBAction func backButtonAction(_ sender: UIButton) {
        self.navigationController?.popViewController(animated: true)
    }
    
}
extension ManageEventViewController: UITableViewDelegate, UITableViewDataSource{
    
    func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
    return 2
    }
    
    func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCell(withIdentifier: ManageEventTableViewCell.identifier) as! ManageEventTableViewCell
        return cell
    }
    
    
}
